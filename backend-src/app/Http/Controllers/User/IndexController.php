<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ChangeRequest;
// use App\Models\Project;
// use App\Models\User;
use Illuminate\Http\Request;
use Parsedown;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $changerequest = ChangeRequest::all();

        $data = [
            'tasks' => $changerequest
        ];
        return view('dashboard', $data);
        // return json_encode($changerequest, true);
    }

    public function viewTask($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);

        $parsedown = new \Parsedown();
        $parsedown->setSafeMode(true);
        $changerequest->description = $parsedown->text($changerequest->description);

        return view('user.view-task', compact('changerequest'));
    }

    public function getTask($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);

        // return view('user.view-task', compact('changerequest'));

        $parsedown = new \Parsedown();
        return $parsedown->text($changerequest->description);
    }
}
