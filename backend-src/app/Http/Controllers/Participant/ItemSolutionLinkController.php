<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ItemSolutionLink;
use Illuminate\Http\Request;

class ItemSolutionLinkController extends Controller
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
            $itemsolutionlink = ItemSolutionLink::where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('url', 'LIKE', "%$keyword%")
                ->orWhere('item_solution_id', 'LIKE', "%$keyword%")
                ->orWhere('type', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $itemsolutionlink = ItemSolutionLink::latest()->paginate($perPage);
        }

        return view('participant.item-solution-link.index', compact('itemsolutionlink'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('participant.item-solution-link.create');
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
			'item_solution_id' => 'required',
			'url' => 'required'
		]);
        $requestData = $request->all();
        
        ItemSolutionLink::create($requestData);

        return redirect('participant/item-solution-link')->with('flash_message', 'ItemSolutionLink added!');
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
        $itemsolutionlink = ItemSolutionLink::findOrFail($id);

        return view('participant.item-solution-link.show', compact('itemsolutionlink'));
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
        $itemsolutionlink = ItemSolutionLink::findOrFail($id);

        return view('participant.item-solution-link.edit', compact('itemsolutionlink'));
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
			'item_solution_id' => 'required',
			'url' => 'required'
		]);
        $requestData = $request->all();
        
        $itemsolutionlink = ItemSolutionLink::findOrFail($id);
        $itemsolutionlink->update($requestData);

        return redirect('participant/item-solution-link')->with('flash_message', 'ItemSolutionLink updated!');
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
        ItemSolutionLink::destroy($id);

        return redirect('participant/item-solution-link')->with('flash_message', 'ItemSolutionLink deleted!');
    }
}
