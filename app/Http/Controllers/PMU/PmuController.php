<?php

namespace App\Http\Controllers\Pmu;

use App\Http\Controllers\Controller;


use App\models\gantt\Task;
use App\models\gantt\Link;
use App\models\timeline\Timeline;
use App\models\taskApproval\TaskApproval;
use App\User;

use Auth;

use Illuminate\Http\Request;

class PmuController extends Controller
{
    public function components()
    {
        $components = Task::select('id','text','progress')
              ->where('parent', '=', 1)
              ->get();
        // return $components;
        return view('pmu.components', compact('components'));
    }

    public function subcomponents()
    {
      // Getting Main component ID
      $main_id = Task::where('parent', '=', 1)
          ->pluck('id');



      $subcomponents = Task::select('id', 'text', 'progress')
          ->whereIn('parent', $main_id)
          ->get();


      return view('pmu.subcomponents', compact('subcomponents'));
    }

    public function subcomponent($id)
    {
      $component = Task::select('text')
          ->where('id', "=", $id)
          ->first();

      $subcomponents = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->get();
      return view('pmu.subcomponent', compact('subcomponents', 'component'));
    }

    public function activity($id)
    {
      $subcomponent = Task::select('text')
          ->where('id', '=', $id)
          ->first();

      $activities = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->get();

      return view('pmu.activity', compact('subcomponent', 'activities'));
    }

    public function activities()
    {
      // Getting Main component ID
      $main_id = Task::where('parent', '=', 1)
          ->pluck('id');

      $sub_id = Task::whereIn('parent', $main_id)
          ->pluck('id');

      $activities = Task::select('id', 'text', 'progress')
          ->whereIn('parent', $sub_id)
          ->get();

        // return $sub_id;
      return view('pmu.activities', compact('activities'));
    }

    public function subactivity($id)
    {
      $activity = Task::select('text')
          ->where('id', '=', $id)
          ->first();

      $subactivities = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->get();

      return view('pmu.subactivity', compact('activity', 'subactivities'));
    }

    public function subactivities()
    {
      // Getting Main component ID
      $main_id = Task::where('parent', '=', 1)
          ->pluck('id');

      $sub_id = Task::whereIn('parent', $main_id)
          ->pluck('id');

      $act_id = Task::whereIn('parent', $sub_id)
          ->pluck('id');

      $subactivities = Task::select('id', 'text', 'progress')
          ->whereIn('parent', $act_id)
          ->get();

      return view('pmu.subactivities', compact('subactivities'));
    }

    public function task($id)
    {
      $subactivity = Task::select('text','id')
          ->where('id', '=', $id)
          ->first();

      $tasks = Task::select('id', 'text', 'progress', 'start_date', 'duration')
          ->where('parent', '=', $id)
          ->get();

      return view('pmu.task', compact('subactivity', 'tasks'));
    }

    public function tasks()
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

      $tasks = Task::select('id', 'text', 'progress')
          ->whereIn('parent', $subact_id)
          ->get();

      return view('pmu.tasks', compact('tasks'));
    }

    public function subtask($id)
    {

      // Getting users
      $users = User::select('id', 'name')
          ->get();

      $task = Task::select('text','parent')
          ->where('id', '=', $id)
          ->first();

      $subactivity = Task::select('text')
          ->where('id', '=', $task['parent'])
          ->first();

      $subtasks = Task::select('id', 'text', 'progress', 'start_date', 'duration', 'staff')
          ->with('user:id,name')
          ->where('parent', '=', $id)
          ->orderby('sortorder', 'ASC')
          ->get();


      return view('pmu.subtask', compact('task', 'subactivity', 'subtasks', 'users'));
    }

    public function assign_staff($subtask_id, $staff_id)
    {
      $user_id = Auth::id();
      // updating Task Table
      $update_assign_staff = Task::Where('id', $subtask_id)->Update(['staff' => $staff_id]);

      // Updating Timeline
      //getting the staff
      $staff = User::select('name')
        ->where('id','=',$staff_id)
        ->first();

      $text = "Assigned to ". $staff->name;

      $new_timeline = Timeline::create(['text' => $text, 'task' => $subtask_id, 'user' => $user_id]);
      return response()->json($new_timeline);
    }

    public function update_progress($subtask_id, $progress)
    {
      $user_id = Auth::id();
      // updating Task Table
      $update_progress = Task::Where('id', $subtask_id)->Update(['progress' => $progress]);

      // Updating Timeline
      if($progress == 1)
        {
          $progress_text = "Completed";
        }else {
          $progress_text = "Pending";
        }
      $text = "Progress Update to ". $progress_text;
      $new_timeline = Timeline::create(['text' => $text, 'task' => $subtask_id, 'user' => $user_id]);
      return response()->json($new_timeline);

    }

    public function my_tasks()
    {
      $user_id = Auth::id();

      // Getting users
      $users = User::select('id', 'name')
          ->get();



      $subtasks = Task::select('id', 'text', 'progress', 'start_date', 'duration', 'staff', 'parent')
          ->with('user:id,name')
          ->where('staff', '=', $user_id)
          ->where('progress', '<', 1)
          ->orderby('sortorder', 'ASC')
          ->get();

      $parent_id = Task::where('staff', '=', $user_id)
          ->where('progress', '<', 1)
          ->pluck('parent');

      $tasks = Task::select('id', 'text')
          ->whereIn('id', $parent_id)
          ->get();

          // return $tasks;
      return view('pmu.mytasks', compact('subtasks', 'users', 'tasks'));

    }

    public function task_timeline($id)
    {

      $user_id = Auth::id();

      //getting users
      $users = User::select('id', 'name')
          ->get();

      //getting the Task Details
      $task_name = Task::select('text','id','progress','staff')
            ->where('id', '=', $id)
            ->with('user:id,name')
            ->first();

      // Get timeline for the tasks
      $timelines = Timeline::select('text','created_at','user as user_id')
          ->where('task', '=', $id)
          ->with('user:id,name')
          ->orderby('created_at','DESC')
          ->get();

      //Getting Pending Approvals
      $approvals = TaskApproval::select('id','staff_id','user_id')
            ->where('task_id','=',$id)
            ->where('approval_status','=',0)
            ->where('status','=',1)
            ->with('user:id,name')
            ->get();

      $approves = TaskApproval::select('id','staff_id','comment','created_at')
            ->where('task_id','=',$id)
            ->where('approval_status','=',1)
            ->where('status','=',1)
            ->with('user:id,name')
            ->get();




      $approval_count = count($approvals);
      $approve_count = count($approves);


      return view('pmu.taskTimeline', compact('task_name','timelines','users','approvals','user_id','approval_count','approves','approve_count'));
    }

    public function assign_approval_staff($task_id,$staff_id)
    {
        $user_id = Auth::id();

        //getting the staff
        $staff = User::select('name')
          ->where('id','=',$staff_id)
          ->first();

        $approval = TaskApproval::create(['task_id' => $task_id, 'staff_id' => $staff_id, 'user_id'=>$user_id]);

        $text = "Set Requird Approval of: ". $staff->name;
        $new_timeline = Timeline::create(['text' => $text, 'task' => $task_id, 'user' => $user_id]);

        return response()->json($approval);
    }

    public function cancel_approval($id)
    {

      $user_id = Auth::id();


      //Validation & Permissions
      $approval = TaskApproval::select('task_id','staff_id','user_id')
          ->where('id','=',$id)
          ->with('user:id,name')
          ->first();


      if($approval['staff_id'] == $user_id or $approval['user_id']==$user_id)
        {

          //Delete the entry
          $del_rec = TaskApproval::where('id','=',$id)
              ->delete();


          //Recording to timelines
          $text = "Required Approval removed for user: ".$approval['user']['name'];
          $new_timeline = Timeline::create(['text' => $text, 'task' => $approval['task_id'], 'user' => $user_id]);

              return response()->json($del_rec);

        }else{
          return 0;
        }

    }

    public function approve($id,$comment)
    {

      $user_id = Auth::id();

      //Validation & Permissions
      $approval = TaskApproval::select('task_id','staff_id','user_id')
          ->where('id','=',$id)
          ->with('user:id,name')
          ->first();


          if($approval['staff_id'] == $user_id)
            {
              //update the status to approved
              $approve = TaskApproval::Where('id', $id)->Update(['approval_status' => 1, 'comment'=>$comment]);

              //updating the timeline
              //Recording to timelines
              $text = "Approved: ";
              $new_timeline = Timeline::create(['text' => $text, 'task' => $approval['task_id'], 'user' => $user_id]);
              return response()->json($approve);
            }else{
                return 0;
            }
    }


}
