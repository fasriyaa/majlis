<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\models\gantt\Task;
use app\User;

class ProcurementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function ongoing_procurements()
    {

      // Getting Main component ID
      $main_id = Task::where('parent', '=', 1)
          ->pluck('id');

      $sub_id = Task::whereIn('parent', $main_id)
          ->pluck('id');

      $act_id = Task::whereIn('parent', $sub_id)
          ->pluck('id');

      $subact_id = Task::whereIn('parent', $act_id)
          ->pluck('id');

      $tasks = Task::select('id', 'text', 'progress','piu_id','procurement')
          ->whereIn('parent', $subact_id)
          ->where('procurement',1)
          ->where('progress','<',1)
          ->with('piu:id,short_name')
          ->orderBy('progress', 'DESC')
          ->get();

      foreach($tasks as $task)
      {
        $last_task = $this->last_completed($task->id);
        $next_task = $this->next_task($task->id);

        if($last_task != null)
            {
              $last_task = $last_task['text'] . " completed on : " . date("d M Y", strtotime($last_task['updated_at']));
            }

        if($next_task != null)
            {
              $next_task = $next_task['text'] . " expected to complete on ". date("d M Y", strtotime($next_task['start_date'] . ' + '.$next_task['duration'] . ' days'));
            }

        $task_info[] = [
            'task_id' => $task->id,
            'last_completed' => $last_task,
            'next_task' => $next_task
        ];
      }

      // return $task_info;
      return view('procurements.ongoing', compact('tasks','task_info'));
    }


    private function last_completed ($parent_id)
    {
      $child_id = Task::where('parent', $parent_id)
          ->pluck('id');

      $last_completed = Task::select('text','sortorder','progress','updated_at')
          ->whereIn('id',$child_id)
          ->where('progress',1)
          ->orderBy('sortorder','DESC')
          ->first();
      return $last_completed;
    }

    private function next_task ($parent_id)
    {
      $child_id = Task::where('parent', $parent_id)
          ->pluck('id');

      $next_task = Task::select('text','sortorder','progress','updated_at','start_date', 'duration')
          ->whereIn('id',$child_id)
          ->where('progress','<', 1)
          ->orderBy('sortorder','ASC')
          ->first();
      return $next_task;
    }

}
