<?php

namespace App\Http\Controllers;


use App\models\gantt\Task;
use App\models\timeline\Timeline;
use App\models\taskApproval\TaskApproval;
use App\models\docs\RequireDoc;
use App\User;
use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }
    public function versionone()
    {

      // Getting subactivies as milestones
      // Getting Main component ID
          $main_id = Task::where('parent', '=', 1)
              ->pluck('id');

          $sub_id = Task::whereIn('parent', $main_id)
              ->pluck('id');

          $act_id = Task::whereIn('parent', $sub_id)
              ->pluck('id');

          $subact_id = Task::whereIn('parent', $act_id)
              ->pluck('id');


          $subactivities = Task::select('id', 'text', 'progress')
              ->whereIn('parent', $act_id)
              ->get();

          $tasks = Task::select('id', 'text', 'progress')
              ->whereIn('parent', $subact_id)
              ->get();

          $overall_progress = Task::select('progress')
              ->where('parent',0)
              ->first();

          //get list of activities due but not completed
          $task_id = Task::whereIn('parent', $subact_id)
              ->pluck('id');



          $dues = Task::select('id','start_date','duration')
                ->whereIn('parent',$task_id)
                ->where('progress', '<', 1)
                ->get();

          $due_count = 0;
          foreach($dues as $due)
          {
            if(date('Y-m-d') > date('Y-m-d', strtotime($due->start_date)))
            {
              // $due_id [] = $due->id;
              $due_count++;
            }
          }


          $milestone = count($subactivities);
          $activities = count($tasks);


        // return count($dues);
        return view('dashboard.v1', compact('milestone', 'activities','overall_progress','due_count'));
    }

    public function versiontwo()
    {
        return view('dashboard.v2');
    }
    public function versionthree()
    {
        return view('dashboard.v3');
    }

    public function livefeed()
    {

        //Getting feed from timeline

        $feeds = Timeline::select('text','task as task_id','updated_at','user as user_id','type','url')
            ->with('user:id,name')
            ->with('task:id,text')
            ->orderby('updated_at','DESC')
            ->limit(20)
            ->get();


            //getting mypending list
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
        // return $feeds;
        return view('dashboard.livefeed',compact('feeds','subtasks', 'users', 'tasks','pending_approvals','user_name','pending_docs'));
    }
}
