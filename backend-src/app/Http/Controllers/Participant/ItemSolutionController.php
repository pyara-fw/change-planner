<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\ItemSolution;
use Illuminate\Http\Request;

class ItemSolutionController extends Controller
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
            $itemsolution = ItemSolution::where('title', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('solution_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $itemsolution = ItemSolution::latest()->paginate($perPage);
        }

        return view('participant.item-solution.index', compact('itemsolution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('participant.item-solution.create');
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
			'solution_id' => 'required'
		]);
        $requestData = $request->all();
        
        ItemSolution::create($requestData);

        return redirect('participant/item-solution')->with('flash_message', 'ItemSolution added!');
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
        $itemsolution = ItemSolution::findOrFail($id);

        return view('participant.item-solution.show', compact('itemsolution'));
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
        $itemsolution = ItemSolution::findOrFail($id);

        return view('participant.item-solution.edit', compact('itemsolution'));
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
			'solution_id' => 'required'
		]);
        $requestData = $request->all();
        
        $itemsolution = ItemSolution::findOrFail($id);
        $itemsolution->update($requestData);

        return redirect('participant/item-solution')->with('flash_message', 'ItemSolution updated!');
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
        ItemSolution::destroy($id);

        return redirect('participant/item-solution')->with('flash_message', 'ItemSolution deleted!');
    }
}
