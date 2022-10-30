<?php

namespace App\Http\Controllers;

use App\Models\SurveyKey;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Response;

class SurveyController extends Controller
{
    /**
     * Create an user on DB, generate an access token, and return it to Landing
     *
     * @param Request $request
     * @return void
     */
    public function provisionUser(Request $request, Response $response, $token)
    {
        // validate token
        $key = $this->validateAndGetKey($token);
        if (!$key) {
            $response->setContent([
                'msg' => 'Error - invalid token'
            ]);
            return $response;
        }

        $userAlreadyExists = false;
        // store this key on local DB
        try {
            $this->storeToken($key);
        } catch (\Illuminate\Database\QueryException $ex) {
            $userAlreadyExists = true;
        } catch (\Exception $ex) {
            return ['msg' => $ex->getMessage()];
        }


        if ($userAlreadyExists) {
            $user = User::where('name', $key)->first();
        } else {
            // provision user
            $user = $this->provisionNewUser($key);
            event(new Registered($user));
        }

        Auth::login($user);

        session()->regenerate();

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    protected function storeToken($key)
    {
        $data = ['key' => $key];
        SurveyKey::create($data);
    }


    protected function validateAndGetKey($token)
    {
        $keyPair  = [
            'secret' => env('KEY_SECRET'),
            'public' => env('KEY_PUBLIC')
        ];

        $keyPairBin = [
            'secret' => hex2bin($keyPair['secret']),
            'public' => hex2bin($keyPair['public']),
        ];

        $decodedBin = \hex2bin($token);
        $key = \sodium_crypto_sign_open($decodedBin, $keyPairBin['public']);
        return $key;
    }


    public function provisionNewUser(string $key)
    {
        $email = "$key@experiment.pyara.org";
        $password = random_bytes(10);

        $user = User::create([
            'name' => $key,
            'email' => $email,
            'password' => Hash::make($password),
        ]);

        return $user;
    }
}
