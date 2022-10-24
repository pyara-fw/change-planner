<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Models\ChangeRequest;
use App\Models\ItemSolution;
use App\Models\Solution;
use Illuminate\Http\Request;
use Parsedown;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $task = Task::all();

        $data = [
            'tasks' => []
        ];

        $parsedown = new \ParsedownExtra();
        foreach ($task as $item) {
            $item->description = $parsedown->text($item->description);
            $data['tasks'][] = $item;
        }

        return view('dashboard', $data);
        // return json_encode($task, true);
    }

    public function viewTask($id)
    {
        // $task = Task::findOrFail($id);
        $task = $this->getTask($id);

        $solution = $this->getSolution($id);

        $data = [
            'task' => $task,
            'solution' => $solution,
            'itemSolutions' => []
        ];
        // dd($data);

        return view('participant.main.view-task', $data);
    }


    public function showFormCreateSolution(Request $request, $taskId)
    {
        $task = $this->getTask($taskId);
        $data = [
            'task' => $task,
            'taskId' => $taskId,
            'formMode' => 'create',
            'userId' => $request->user()->id
        ];
        // dd($data);

        return view('participant.main.create-solution', $data);
    }

    public function createSolution(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'task_id' => 'required'
        ]);
        $requestData = $request->all();

        Solution::create($requestData);

        $url ='/task/'. $request->get('task_id');

        return redirect($url)->with('flash_message', 'Solution added!');
    }



    public function viewTask2($id)
    {
        $task = Task::findOrFail($id);

        $parsedown = new \ParsedownExtra();
        $task->description = $parsedown->text($task->description);

        $solution = [
            'id' => 1,
            'statusTitle' => 'Not started',
            'description' => '# Here is the title {.hdr1}
And now some description...
            '
        ];

        $solution['description'] = $parsedown->text($solution['description']);

        $data = [
            'task' => $task,
            'solution' => $solution,
            'itemSolutions' => []
        ];

        $data['itemSolutions'][] = [
            'id' => 1,
            'title' => 'create table X',
            'description' => 'Create the migration',
            'links' => []
        ];

        $data['itemSolutions'][] = [
            'id' => 2,
            'title' => 'create route for endpoint',
            'description' => 'Create the rount on file X. This is a long description to verify how it will work with the buttons on this current layout. Lets see if it will break the lines accordingly. Create the rount on file X. This is a long description to verify how it will work with the buttons on this current layout. Lets see if it will break the lines accordingly.Create the rount on file X. This is a long description to verify how it will work with the buttons on this current layout. Lets see if it will break the lines accordingly.'
            ,
            'links' => []
        ];

        $data['itemSolutions'][] = [
            'id' => 3,
            'title' => 'create route for endpoint',
            'description' => 'Create the rount on file X',
            'links' => [
                [
                    'title' => 'My image',
                    'description' => '',
                    'url' => 'https://x.com/mylink.png',
                    'type' => 'image'
                ],
                [
                    'title' => 'My PDF',
                    'description' => '',
                    'url' => 'https://x.com/mylink.pdf',
                    'type' => 'document'
                ],
            ]
        ];

        return view('participant.main.view-task', $data);
    }

    public function getTask($id)
    {
        $task = Task::findOrFail($id);

        $parsedown = new \ParsedownExtra();
        $task->description = $parsedown->text($task->description);

        return $task;
    }

    public function getSolution($taskId)
    {
        try {
            $solution = Solution::where('task_id', $taskId)
                ->firstOrFail();
        } catch (\Exception $e) {
            $solution = null;
        }

        return $solution;
    }


    public function showFormCreateItemSolution($solutionId)
    {
        return view('participant.main.create-item-solution', [
            'solutionId' => $solutionId
        ]);
    }

    public function storeItemSolution(Request $request, $solutionId)
    {
        $this->validate($request, [
            'solution_id' => 'required'
        ]);
        $requestData = $request->all();

        ItemSolution::create($requestData);

        return redirect('solution/' . $solutionId)->with('flash_message', 'Item Solution added!');
    }
}
