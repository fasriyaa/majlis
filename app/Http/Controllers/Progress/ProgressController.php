<?php

namespace App\Http\Controllers\Progress;

use App\Http\Controllers\Controller;

use App\models\progress\Progress;
use Illuminate\Http\Request;
use App\models\gantt\Task;
use App\models\gantt\Link;
use App\models\timeline\Timeline;
use App\models\taskApproval\TaskApproval;
use App\models\docs\RequireDoc;
use App\models\piu\piu;
use App\models\discussions\TaskDiscussions;
use App\User;

use Auth;

class ProgressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $permission = "View Progress Reports";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
          return view('progress.index');
          }else {
            return view($err_url);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function show(Progress $progress)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function edit(Progress $progress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Progress $progress)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Progress  $progress
     * @return \Illuminate\Http\Response
     */
    public function destroy(Progress $progress)
    {
        //
    }

    public function live_progress()
    {
      $permission = "View Progress Reports";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //Components
        $components = Task::select('id','text','parent')
              ->where('parent',1)
              ->with('children:parent,id,text')
              ->get();

        // Getting Main component ID
        $main_id = Task::where('parent', '=', 1)
            ->pluck('id');

        $sub_id = Task::whereIn('parent', $main_id)
            ->pluck('id');

        $activities_id = Task::whereIn('parent', $sub_id)
                ->pluck('id');

        $activities = Task::select('id', 'text', 'progress')
            ->whereIn('parent', $sub_id)
            ->get();

        $subactivies_id = Task::whereIn('parent', $activities_id)
            ->pluck('id');

        $task_id = Task::select('id')
              ->whereIn('parent', $subactivies_id)
              ->get();



        $comments = [];
        foreach ($task_id as $value) {
          $comment = $this->task_comments($value->id);
          $last_completed = $this->last_completed($value->id);

          if($last_completed['text']!= null)
              {
                  $comments[] = [
                      'task_id' => $value->id,
                      'comment' => $last_completed['text'] . " Completed; " .$comment['comment']
                  ];
              }else {

                  if($comment['updated_at'] < $last_completed['updated_at'])
                  {
                    $comments[] = [
                        'task_id' => $value->id,
                        'comment' => $last_completed['text'] . " Completed; "
                    ];
                  }
                  else {
                        $comments[] = [
                            'task_id' => $value->id,
                            'comment' => $comment['comment']
                        ];
                      }
                  }


        }


        //get last completed task



        // return $comments;
          // return $components;
        return view('progress.live_progress', compact('activities','components','comments'));
          }else {
            return view($err_url);
      }
    }

    private function task_comments($parent_id)
    {
      $child_id = Task::where('parent',$parent_id)
          ->pluck('id');

      $comments = TaskDiscussions::select('id','comment','updated_at')
          ->wherein('task_id',$child_id)
          ->orderBy('updated_at','DESC')
          ->first();
      return $comments;
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


}
