<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\SurveyKey;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Response;
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

        // return ['msg'=>'ok', 'key'=>$key];
    }

    protected function storeToken($key)
    {
        $data = ['key' => $key];
        SurveyKey::create($data);
    }

    // public function test(Request $request, $key)
    // {
    //     $keyPair  = [
    //         'secret' => env('KEY_SECRET'),
    //         'public' => env('KEY_PUBLIC')
    //     ];

    //     $keyPairBin = [
    //         'secret' => hex2bin($keyPair['secret']),
    //         'public' => hex2bin($keyPair['public']),
    //     ];

    //     $signedBin = \sodium_crypto_sign($key, $keyPairBin['secret']);
    //     $token = \bin2hex($signedBin);

    //     return [
    //         'key' => $key,
    //         'token' => $token
    //     ];
    // }


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

    /**
     * Receive a token and create a session
     *
     * @param Request $request
     * @param [type] $token
     * @return void
     */
    // public function authenticate(Request $request, $token)
    // {
    //     $keyPair  = [
    //         'secret' => env('KEY_SECRET'),
    //         'public' => env('KEY_PUBLIC')
    //     ];

    //     $keyPairBin = [
    //         'secret' => hex2bin($keyPair['secret']),
    //         'public' => hex2bin($keyPair['public']),
    //     ];


    //     // userId : random payload : signature
    //     $userId = '1';
    //     $random = \bin2hex(\random_bytes(10));
    //     $input = "$userId:$random";
    //     $signedBin = \sodium_crypto_sign($input, $keyPairBin['secret']);
    //     $signedText = \bin2hex($signedBin);

    //     $receivedSignedText = $signedText;

    //     // $receivedSignedText .= '00';

    //     $decodedBin = \hex2bin($receivedSignedText);
    //     $output = \sodium_crypto_sign_open($decodedBin, $keyPairBin['public']);


    //     $response  = [
    //         'input' => $input,
    //         'signedText' => $signedText,
    //         'output' => $output
    //     ];
    //     if ($output) {
    //         session()->regenerate();
    //         return redirect()->intended(RouteServiceProvider::HOME);
    //     }


    //     //dd($input);
    //     return $response;
    // }

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
