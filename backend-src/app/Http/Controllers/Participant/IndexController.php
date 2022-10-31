<?php

namespace App\Http\Controllers\Participant;

use App\Http\Controllers\Controller;

use App\Models\Task;
use App\Models\ChangeRequest;
use App\Models\ItemSolution;
use App\Models\ItemSolutionLink;
use App\Models\Solution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Parsedown;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        $tasks = DB::table('tasks')
                    ->leftJoin('solutions', function ($join) use ($request) {
                        $join->on('solutions.task_id', '=', 'tasks.id')
                        ->where('solutions.user_id', '=', $request->user()->id);
                    })
                    ->select('tasks.*', 'solutions.id as solution_id', 'solutions.status as solution_status')
                    ->get();

        $data = [
            'tasks' => []
        ];


        $countStatus = [];
        foreach ($tasks as $item) {
            $item->description = $this->renderMarkdown($item->description);
            $item->formattedTags = $this->formatTags($item->tags);
            $item->formattedStatus = $this->formatTaskStatus($item, $request->user()->id);
            $data['tasks'][] = $item;
            if (!isset($countStatus[$item->formattedStatus[1]])) {
                $countStatus[$item->formattedStatus[1]] = 0;
            }
            $countStatus[$item->formattedStatus[1]]++;
        }
        $data['statusCount'] = $countStatus;
        $data['postSurveyURL'] = env('POST_SURVEY_URL') .Auth::user()->name;



        return view('dashboard', $data);
    }

    protected function formatTags($strTags)
    {
        $response = [];
        $lsTags = explode(';', $strTags);
        foreach ($lsTags as $tag) {
            $parts = explode(':', $tag);
            if (count($parts) == 1) {
                $response[] = [
                    'class' => 'badge-primary',
                    'text' => $parts[0]
                ];
            } elseif (count($parts) == 2) {
                $response[] = [
                    'class' => 'badge-' . $this->selectColorBadge(trim($parts[0])),
                    'text' => $parts[1]
                ];
            }
        }
        return $response;
    }

    protected function selectColorBadge($parm)
    {
        switch ($parm) {
            case 'red':
                return 'danger';
            case 'silver':
                return 'secondary';
            case 'green':
                return 'success';
            case 'orange':
                return 'warning';
            case 'blue':
            default:
                return 'primary';
        }
    }

    protected function formatTaskStatus($task, $userId)
    {
        $solution = $this->getSolutionByTask($task->id, $userId);
        if (!$solution) {
            return [$this->selectColorBadge('red'),'Pending'];
        } elseif ($solution->status === Solution::STATUS_SUBMITTED) {
            return [$this->selectColorBadge('silver'),'Submitted'];
        } else {
            return [$this->selectColorBadge('blue'),'In Progress'];
        }
    }

    public function viewTask(Request $request, $id)
    {
        $data = $this->getViewTaskSolutionData($id, null, $request->user()->id);

        return view('participant.main.view-task', $data);
    }


    public function showFormCreateSolution(Request $request, $taskId)
    {
        $task = $this->getTask($taskId);
        $data = [
            'task' => $task,
            'userId' => $request->user()->id
        ];

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




    public function getTask($id)
    {
        $task = Task::findOrFail($id);

        $task->description = $this->renderMarkdown($task->description);

        return $task;
    }

    protected function renderMarkdown($text)
    {
        $parsedown = new \ParsedownExtra();
        $response = $parsedown->text($text);

        $response = preg_replace('/<a(.*)>/m', '<a target="_blank" ${1} >', $response);

        return $response ;
    }

    public function getSolutionByTask($taskId, $userId)
    {
        try {
            $solution = Solution::where('task_id', $taskId)
                ->where('user_id', $userId)
                ->firstOrFail();
        } catch (\Exception $e) {
            $solution = null;
        }

        return $solution;
    }

    public function getSolution($solutionId)
    {
        try {
            $solution = Solution::findOrFail($solutionId);
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

        return redirect()
            ->route('show-solution', ['solutionId' => $solutionId])
            ->with('flash_message', 'Item Solution added!');
    }

    public function updateSolution(Request $request, $solutionId)
    {
        $requestData = $request->all();
        $requestData['user_id'] = $request->user()->id;

        $solution = Solution::findOrFail($solutionId);
        $solution->update($requestData);

        return redirect()->route('show-solution', ['solutionId'=>$solutionId])->with('flash_message', 'Solution updated!');
    }

    public function viewSolution(Request $request, $solutionId)
    {
        $data = $this->getViewTaskSolutionData(null, $solutionId, $request->user()->id);

        return view('participant.main.view-task', $data);
    }

    protected function getViewTaskSolutionData($taskId=null, $solutionId=null, $userId=null)
    {
        $itemSolutions = [];

        if ($taskId) {
            $solution = $this->getSolutionByTask($taskId, $userId);
        } else {
            $solution = $this->getSolution($solutionId);
        }


        if (is_null($solution)) {
            $task = $this->getTask($taskId);
        } else {
            $task = $this->getTask($solution->task_id);
            $itemSolutions = ItemSolution::where('solution_id', $solution->id)->get();
        }


        $data = [
            'task' => $task,
            'solution' => $solution,
            'itemSolutions' => $itemSolutions
        ];
        return $data;
    }

    public function showFormEditSolutionDescription(Request $request, $solutionId)
    {
        $solution = $this->getSolution($solutionId);

        if (!$solution) {
            throw new \Exception("Solution not found", 404);
        }

        $task = $this->getTask($solution->task_id);

        $data = [
            'task' => $task,
            'userId' => $request->user()->id,
            'solution' => $solution
        ];
        return view('participant.main.edit-solution', $data);
    }


    public function showFormEditItemSolution(Request $request, $solutionId, $itemId)
    {
        $itemSolution = $this->getItemSolution($solutionId, $itemId);

        if (!$itemSolution) {
            return redirect()
            ->route('show-solution', ['solutionId' => $solutionId])
            ->with('flash_message', 'Invalid item $itemId');
        }

        return view('participant.main.edit-item-solution', [
            'itemSolution' => $itemSolution,
            'solutionId' => $solutionId
        ]);
    }


    protected function getItemSolution($solutionId, $itemId)
    {
        $item = ItemSolution::where('id', $itemId)->
            where('solution_id', $solutionId)->
            first();
        return $item;
    }

    public function updateItemSolution(Request $request, $solutionId, $itemId)
    {
        $requestData = $request->all();
        $itemSolution = $this->getItemSolution($solutionId, $itemId);


        if (!$itemSolution) {
            return redirect()
            ->route('show-solution', ['solutionId' => $solutionId])
            ->with('flash_message', 'Invalid item $itemId');
        }

        $itemSolution->update($requestData);

        return redirect()->route('show-solution', ['solutionId'=>$solutionId])->with('flash_message', 'Item Solution updated!');
    }

    public function removeItemSolution(Request $request, $solutionId, $itemId)
    {
        ItemSolution::destroy($itemId);

        return redirect()->route('show-solution', ['solutionId'=>$solutionId])->with('flash_message', 'Item Solution removed!');
    }

    public function showFormCreateLinkItemSolution(Request $request, $solutionId, $itemId)
    {
        return view('participant.main.create-link-item-solution', [
            'solutionId' => $solutionId,
            'itemId' => $itemId
        ]);
    }

    public function storeLinkItemSolution(Request $request, $solutionId, $itemId)
    {
        $this->validate($request, [
            'item_solution_id' => 'required',
            'url' => 'required'
        ]);
        $requestData = $request->all();

        if ($requestData['item_solution_id'] != $itemId) {
            throw new \Exception("Mismatch item ID: $itemId != ".$requestData['item_solution_id']);
        }

        ItemSolutionLink::create($requestData);

        return redirect()
            ->route('show-solution', ['solutionId' => $solutionId])
            ->with('flash_message', 'Item Solution added!');
    }

    public function removeLinkItemSolution(Request $request, $solutionId, $itemId, $linkId)
    {
        ItemSolutionLink::destroy($linkId);
        return redirect()->route('show-solution', ['solutionId'=>$solutionId])->with('flash_message', 'Item Solution removed!');
    }

    public function showFormEditLinkItemSolution(Request $request, $solutionId, $itemId, $linkId)
    {
        $linkItemSolution = ItemSolutionLink::find($linkId);

        if (!$linkItemSolution) {
            return redirect()
            ->route('show-solution', ['solutionId' => $solutionId])
            ->with('flash_message', 'Invalid link $linkItemSolution');
        }

        return view('participant.main.edit-link-item-solution', [
            'linkItemSolution' => $linkItemSolution,
            'solutionId' => $solutionId,
            'itemId' => $itemId,
            'linkId' => $linkId
        ]);
    }

    public function updateLinkItemSolution(Request $request, $solutionId, $itemId, $linkId)
    {
        $this->validate($request, [
            'url' => 'required'
        ]);
        $requestData = $request->all();
        $requestData['item_solution_id'] = $itemId;

        $itemsolutionlink = ItemSolutionLink::findOrFail($linkId);
        $itemsolutionlink->update($requestData);

        return redirect()->route('show-solution', ['solutionId'=>$solutionId])->with('flash_message', 'Item Solution updated!');
    }
}
