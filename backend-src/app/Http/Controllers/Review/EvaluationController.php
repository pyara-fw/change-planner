<?php

namespace App\Http\Controllers\Review;

use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
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
            $evaluation = Evaluation::where('data', 'LIKE', "%$keyword%")
                ->orWhere('description', 'LIKE', "%$keyword%")
                ->orWhere('solution_id', 'LIKE', "%$keyword%")
                ->orWhere('user_id', 'LIKE', "%$keyword%")
                ->latest()->paginate($perPage);
        } else {
            $evaluation = Evaluation::latest()->paginate($perPage);
        }

        return view('review.evaluation.index', compact('evaluation'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('review.evaluation.create');
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
			'solution_id' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        Evaluation::create($requestData);

        return redirect('review/evaluation')->with('flash_message', 'Evaluation added!');
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
        $evaluation = Evaluation::findOrFail($id);

        return view('review.evaluation.show', compact('evaluation'));
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
        $evaluation = Evaluation::findOrFail($id);

        return view('review.evaluation.edit', compact('evaluation'));
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
			'solution_id' => 'required',
			'user_id' => 'required'
		]);
        $requestData = $request->all();
        
        $evaluation = Evaluation::findOrFail($id);
        $evaluation->update($requestData);

        return redirect('review/evaluation')->with('flash_message', 'Evaluation updated!');
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
        Evaluation::destroy($id);

        return redirect('review/evaluation')->with('flash_message', 'Evaluation deleted!');
    }
}
