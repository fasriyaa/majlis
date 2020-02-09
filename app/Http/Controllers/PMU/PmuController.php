<?php

namespace App\Http\Controllers\Pmu;

use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use App\Http\Controllers\Traits\FileUploadTrait;


use App\models\gantt\Task;
use App\models\gantt\Link;
use App\models\timeline\Timeline;
use App\models\taskApproval\TaskApproval;
use App\models\docs\RequireDoc;
use App\models\piu\piu;
use App\User;

use Auth;

use Illuminate\Http\Request;

class PmuController extends Controller
{
  use FileUploadTrait;

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
      $component = Task::select('text','parent')
          ->where('id', "=", $id)
          ->first();

      $subcomponents = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->get();

      // return $component;

      return view('pmu.subcomponent', compact('subcomponents', 'component'));
    }

    public function activity($id)
    {
      $subcomponent = Task::select('id','text','parent')
          ->where('id', '=', $id)
          ->first();


      $activities = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->orderby('sortorder','ASC')
          ->get();

      // return $subcomponent;
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
      $activity = Task::select('id','text','parent')
          ->where('id', '=', $id)
          ->first();

      $subactivities = Task::select('id', 'text', 'progress')
          ->where('parent', '=', $id)
          ->orderby('sortorder','ASC')
          ->get();

      //getting subcomponent
      $subcomponent = Task::select('parent')
            ->where('id',$activity['parent'])
            ->first();

      // return $activity;

      return view('pmu.subactivity', compact('activity', 'subactivities','subcomponent'));
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
      $subactivity = Task::select('text','id','parent')
          ->where('id', '=', $id)
          ->first();

      $tasks = Task::select('id', 'text', 'progress', 'start_date', 'duration')
          ->where('parent', '=', $id)
          ->orderby('sortorder','ASC')
          ->get();

      $activity = Task::select('parent')
              ->where('id',$subactivity['parent'])
              ->first();

      $subcomponent = Task::select('parent')
                ->where('id',$activity['parent'])
                ->first();

      // return $subcomponent;

      return view('pmu.task', compact('subactivity', 'tasks','activity','subcomponent'));
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

      $tasks = Task::select('id', 'text', 'progress','piu_id')
          ->whereIn('parent', $subact_id)
          ->with('piu:id,short_name')
          ->get();

      // return $tasks;

      //getting piu list
      $pius = piu::all();

      return view('pmu.tasks', compact('tasks','pius'));
    }

    public function subtask($id)
    {

      // Getting users
      $users = User::select('id', 'name')
          ->get();

      $task = Task::select('id','text','parent')
          ->where('id', '=', $id)
          ->first();

      $subactivity = Task::select('parent','text')
          ->where('id', '=', $task['parent'])
          ->first();

      $subtasks = Task::select('id', 'text', 'progress', 'start_date', 'duration', 'staff')
          ->with('user:id,name')
          ->where('parent', '=', $id)
          ->orderby('sortorder', 'ASC')
          ->get();

      $activity = Task::select('parent')
          ->where('id',$subactivity['parent'])
          ->first();

      $subcomponent = Task::select('parent')
          ->where('id',$activity['parent'])
          ->first();

      // return $subcomponent;


      return view('pmu.subtask', compact('task', 'subactivity', 'subtasks', 'users','activity','subcomponent'));
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

      $new_timeline = Timeline::create(['text' => $text, 'task' => $subtask_id, 'user' => $user_id, 'type'=>1]);
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
      $new_timeline = Timeline::create(['text' => $text, 'task' => $subtask_id, 'user' => $user_id, 'type'=>2]);


      //updating progress of level Task
        $task = Task::where('id',$subtask_id)
                  ->pluck('parent');

        $data = Task::select('progress','duration')
                  ->where('parent',$task)
                  ->get('duration');

        $sigma_dp = 0;
        $sigma_d = 0;
        foreach ($data as $dp) {
          $sigma_dp = $sigma_dp + ($dp['duration']*$dp['progress']);
          $sigma_d = $sigma_d + ($dp['duration']);
        }

        $update_progress = Task::Where('id', $task)
                ->Update(['progress' => round($sigma_dp/$sigma_d,2)]);
      //end updating progress of parent task

      //updating progress of level Sub-Activity
        $sub_activity = Task::where('id',$task)
                  ->pluck('parent');

        $data = Task::select('progress','duration')
                  ->where('parent',$sub_activity)
                  ->get('duration');

        $sigma_dp = 0;
        $sigma_d = 0;
        foreach ($data as $dp) {
          $sigma_dp = $sigma_dp + ($dp['duration']*$dp['progress']);
          $sigma_d = $sigma_d + ($dp['duration']);
        }

        $update_progress = Task::Where('id', $sub_activity)
                ->Update(['progress' => round($sigma_dp/$sigma_d,2)]);
      //end updating progress of sub activity

      //updating progress of level Activity
        $activity = Task::where('id',$sub_activity)
                  ->pluck('parent');

        $data = Task::select('progress','duration')
                  ->where('parent',$activity)
                  ->get('duration');

        $sigma_dp = 0;
        $sigma_d = 0;
        foreach ($data as $dp) {
          $sigma_dp = $sigma_dp + ($dp['duration']*$dp['progress']);
          $sigma_d = $sigma_d + ($dp['duration']);
        }

        $update_progress = Task::Where('id', $activity)
                ->Update(['progress' => round($sigma_dp/$sigma_d,2)]);
      //end updating progress of activity

      //updating progress of level sub component
        $sub_component = Task::where('id',$activity)
                  ->pluck('parent');

        $data = Task::select('progress','duration')
                  ->where('parent',$sub_component)
                  ->get('duration');

        $sigma_dp = 0;
        $sigma_d = 0;
        foreach ($data as $dp) {
          $sigma_dp = $sigma_dp + ($dp['duration']*$dp['progress']);
          $sigma_d = $sigma_d + ($dp['duration']);
        }

        $update_progress = Task::Where('id', $sub_component)
                ->Update(['progress' => round($sigma_dp/$sigma_d,2)]);
      //end updating progress of subcomponent

      //updating progress of level Components
        $component = Task::where('id',$sub_component)
                  ->pluck('parent');

        $data = Task::select('progress','duration')
                  ->where('parent',$component)
                  ->get('duration');

        $sigma_dp = 0;
        $sigma_d = 0;
        foreach ($data as $dp) {
          $sigma_dp = $sigma_dp + ($dp['duration']*$dp['progress']);
          $sigma_d = $sigma_d + ($dp['duration']);
        }

        $update_progress = Task::Where('id', $component)
                ->Update(['progress' => round($sigma_dp/$sigma_d,2)]);
      //end updating progress of components


      return response()->json($new_timeline);

    }

    public function my_tasks()
    {
      $user_id = Auth::id();

      // Getting users
      $users = User::select('id', 'name')
          ->get();

      $user_name = User::select('name')
            ->where('id','=',$user_id)
            ->first();


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

      //getting pending approvals for the staff
      $pending_approvals = TaskApproval::select('task_id')
          ->where('staff_id','=',$user_id)
          ->where('approval_status','=',0)
          ->where('status','=',1)
          ->with('task:id,text,start_date,duration,progress')
          ->get();


      $pending_docs_id = RequireDoc::where('status','=',1)
          ->pluck('task_id');

      $pending_docs = Task::select('id','start_date','text','progress','duration')
          ->whereIn('id',$pending_docs_id)
          ->where('staff', '=', $user_id)
          ->get();


      //getting list task assigned by the user
      $assigned_task_list = Timeline::where('user','=',$user_id)
          ->where('type','=',1)
          ->groupBy('task')
          ->pluck('task');

      $assigned_tasks = Task::select('id','start_date','text','progress','duration','staff')
          ->whereIn('id',$assigned_task_list)
          ->where('staff','!=',$user_id)
          ->with('user:id,name')
          ->get();

      // return $assigned_tasks;
      return view('pmu.mytasks', compact('subtasks', 'users', 'tasks','pending_approvals','user_name','pending_docs','assigned_tasks'));

    }

    public function task_timeline($id)
    {

      $user_id = Auth::id();

      //getting users
      $users = User::select('id', 'name')
          ->get();

      //getting the Task Details
      $task_name = Task::select('text','id','progress','staff','parent')
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

      $req_docs = RequireDoc::select('id','status')
            ->where('task_id','=',$id)
            ->where('status','=',1)
            ->get();

      $documents = RequireDoc::select('doc_name','updated_at')
            ->where('task_id','=',$id)
            ->where('status','=',2)
            ->get();


      $approval_count = count($approvals);
      $approve_count = count($approves);
      $documents_count = count($documents);
      $req_docs_count = count($req_docs);


      return view('pmu.taskTimeline', compact('task_name','timelines','users','approvals','user_id','approval_count','approves','approve_count','req_docs','documents','documents_count','req_docs_count'));
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
        $new_timeline = Timeline::create(['text' => $text, 'task' => $task_id, 'user' => $user_id, 'type' => 7]);

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
          $new_timeline = Timeline::create(['text' => $text, 'task' => $approval['task_id'], 'user' => $user_id, 'type' => 7]);

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
              $new_timeline = Timeline::create(['text' => $text, 'task' => $approval['task_id'], 'user' => $user_id, 'type' => 7]);
              return response()->json($approve);
            }else{
                return 0;
            }
    }

    public function require_doc($id)
    {
      $user_id = Auth::id();

      $req_doc = RequireDoc::select('id')
          ->where('task_id','=',$id)
          ->first();

          if($req_doc)
          {
              return response()->json(0);
          }else {

              $new_req_doc = RequireDoc::create(['task_id'=>$id]);

              //Recording to timelines
              $text = "Set Document Required";
              $new_timeline = Timeline::create(['text' => $text, 'task' => $id, 'user' => $user_id, 'type'=>6]);


              return response()->json(1);
          }

    }

    public function cancel_doc($id)
    {

      $user_id = Auth::id();


      //Validation & Permissions
      $req_doc = RequireDoc::select('task_id','status')
          ->where('id','=',$id)
          ->with('task:id,staff')
          ->first();

      if($req_doc['status']==1 && $req_doc['task']['staff']==$user_id)
        {

          // Delete the entry
              $del_rec = RequireDoc::where('id','=',$id)
                  ->delete();


          //Recording to timelines
          $text = "Document Required Canclled";
          $new_timeline = Timeline::create(['text' => $text, 'task' => $req_doc['task']['id'], 'user' => $user_id, 'type'=>6]);

          return response()->json(1);

        }else {
          return response()->json(0);
        }
    }

    public function upload_doc(Request $request)
    {
          $user_id = Auth::id();
          $file_name = $request->file('file')->getClientOriginalName();
          $request = $this->saveFiles($request);

          //Updating the Required Doc
          $req_doc = RequireDoc::select('id')
              ->where('task_id','=', $request->subtask6_id)
              ->where('status','=',1)
              ->first();

          if($req_doc)
          {
            $up_doc = RequireDoc::Where('id', $req_doc['id'])->Update(['doc_name' => $request->input('file'), 'status' => 2]);
          }else {
            $up_doc = RequireDoc::create(['task_id'=>$request->subtask6_id, 'doc_name'=>$request->input('file'),'status'=>2]);
          }

          //updating the timeline
          $text = "Uploaded Document ". $file_name;
          $url = "/files" . $file_name;

          // $new_record = new_timeline($text, $request->subtask6_id,0);
          $new_timeline = Timeline::create(['text' => $text, 'task' => $request->subtask6_id, 'user' => $user_id, 'url' => $url, 'type' => 6]);

          return redirect()->route('pmu.task_timeline', [$request->subtask6_id]);
    }

    public function toTaskTimeline($id)
    {
      //getting parent ID
      $parent = Task::where('id','=',$id)
            ->first('parent');

      return redirect()->route('pmu.subtask', [$parent['parent']]);
      return $parent;
    }





}
