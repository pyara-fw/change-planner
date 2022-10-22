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
            'tasks' => []
        ];

        $parsedown = new \ParsedownExtra();
        foreach ($changerequest as $item) {
            $item->description = $parsedown->text($item->description);
            $data['tasks'][] = $item;
        }

        return view('dashboard', $data);
        // return json_encode($changerequest, true);
    }

    public function viewTask($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);

        $parsedown = new \ParsedownExtra();
        // $parsedown->setSafeMode(true);
        $changerequest->description = $parsedown->text($changerequest->description);

        $changeplan = [
            'statusTitle' => 'Not started',
            'description' => ''
        ];

        $data = [
            'changerequest' => $changerequest,
            'changeplan' => $changeplan,
            'changeitems' => []
        ];

        $data['changeitems'][] = [
            'title' => 'create table X',
            'description' => 'Create the migration'
        ];

        $data['changeitems'][] = [
            'title' => 'create route for endpoint',
            'description' => 'Create the rount on file X'
        ];

        $data['changeitems'][] = [
            'title' => 'create route for endpoint',
            'description' => 'Create the rount on file X'
        ];

        return view('user.view-task', $data);
    }

    public function getTask($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);

        // return view('user.view-task', compact('changerequest'));

        $parsedown = new \Parsedown();
        return $parsedown->text($changerequest->description);
    }
}
