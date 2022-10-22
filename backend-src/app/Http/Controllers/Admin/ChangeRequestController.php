<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ChangeRequest;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ChangeRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $perPage = 25;

        if (!empty($keyword)) {
            $changerequest = ChangeRequest::where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('project_id', 'LIKE', "%$keyword%")
                ->orWhere('reporter_user_id', 'LIKE', "%$keyword%")
                ->orWhere('assigned_user_id', 'LIKE', "%$keyword%")
                ->orWhere('status', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $changerequest = ChangeRequest::latest()->paginate($perPage);
        }

        return view('admin.change-request.index', compact('changerequest'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $data = [];
        $data['list_users'] = User::all();
        $data['list_projects'] = Project::all();

        return view('admin.change-request.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'project_id' => 'required',
            'status' => 'required'
        ]);
        $requestData = $request->all();

        ChangeRequest::create($requestData);

        return redirect('admin/change-request')->with('flash_message', 'ChangeRequest added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);

        return view('admin.change-request.show', compact('changerequest'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $changerequest = ChangeRequest::findOrFail($id);
        $data = compact('changerequest');
        $data['list_users'] = User::all();
        $data['list_projects'] = Project::all();

        return view('admin.change-request.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'title' => 'required',
            'project_id' => 'required',
            'status' => 'required'
        ]);
        $requestData = $request->all();

        $changerequest = ChangeRequest::findOrFail($id);
        $changerequest->update($requestData);

        return redirect('admin/change-request')->with('flash_message', 'ChangeRequest updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy($id)
    {
        ChangeRequest::destroy($id);

        return redirect('admin/change-request')->with('flash_message', 'ChangeRequest deleted!');
    }
}
