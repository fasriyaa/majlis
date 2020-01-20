<?php

namespace App\Http\Controllers\Discussions;

use App\Http\Controllers\Controller;
use App\models\discussions\Discussions;
use Illuminate\Http\Request;

use App\models\gantt\Task;
use App\models\discussions\TaskDiscussions;
use App\models\discussions\DiscussionParticipants;
use App\models\docs\RequireDoc;
use App\User;


class DiscussionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //PMU Discussions
        $pmu_lists = Discussions::select('id','created_at','status')
            ->where('type',3)
            ->orderby('id','DESC')
            ->get();
        return view('discussions.pmu_daily_list',compact('pmu_lists'));
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

        $discussion = new Discussions();

        $discussion->type = $request->input('type');
        $discussion->status = 1; //1 for open

        $discussion->save();

        if($request->input('type') == 3)
        {
            $data = $this->discussion_task($discussion->id);
        }
        return redirect()->route('pmu_daily_list.index');
        // return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discussions  $discussions
     * @return \Illuminate\Http\Response
     */
    public function show(Discussions $discussions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discussions  $discussions
     * @return \Illuminate\Http\Response
     */
    public function edit(Discussions $discussions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discussions  $discussions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discussions $discussions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discussions  $discussions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discussions $discussions)
    {
        //
    }

    private function discussion_task($id)
    {
      //getting all the subtasks
      // Getting Main component ID
      $main_id = Task::where('parent', '=', 1)
          ->pluck('id');

      $sub_id = Task::whereIn('parent', $main_id)
          ->pluck('id');

      $act_id = Task::whereIn('parent', $sub_id)
          ->pluck('id');

      $subact_id = Task::whereIn('parent', $act_id)
          ->pluck('id');

      $tasks_id = Task::whereIn('parent', $subact_id)
          ->pluck('id');


      //storing the relevent ids to array

      foreach ($tasks_id as $task_id) {

        $subtasks = Task::select('id')
            ->where('parent', $task_id)
            ->where('progress','<',1)
            ->orderby('sortorder','ASC')
            ->first();

        if($subtasks['id'] != null)
            {
              $task_dis = new TaskDiscussions();
              $task_dis->discussion_id = $id;
              $task_dis->task_id = $subtasks['id'];

              $task_dis->save();
            }
      }


      return 3; // for pmu daily meetings



    }

    public function pmu_daily_meeting($id)
    {

      //Getting Discussion Status
      $discussion_status = Discussions::select('id','status')
            ->where('id',$id)
            ->first();

      $subtasks = TaskDiscussions::select('task_id','comment','next_step','status')
          ->where('discussion_id',$id)
          ->with('task:id,text')
          ->get();

      $subtasks_id = TaskDiscussions::where('discussion_id',$id)
          ->pluck('task_id');

      $next_item = TaskDiscussions::select('id as item_id','task_id','comment','next_step','status')
          ->where('discussion_id',$id)
          ->where('status',1)
          ->with('task:id,text,staff')
          ->first();

      //getting assinged staff
      $assinged_staff = User::select('name')
          ->where('id',$next_item->task['staff'])
          ->first();

      // Getting users
      $users = User::select('id', 'name')
          ->get();

      $participants = DiscussionParticipants::select('user_id')
          ->where('discussion_id',$id)
          ->with('user:id,name')
          ->get();



      $docs = RequireDoc::select('doc_name')
          ->wherein('task_id',$subtasks_id )
          ->get();

        // return $assinged_staff;
      return view('discussions.pmu_daily_meeting',compact('subtasks','discussion_status','next_item','users','participants','docs','assinged_staff'));
    }

    public function review(Request $request)
    {
      $review = TaskDiscussions::find($request->input('id'));

      $review->comment = $request->input('status');
      $review->next_step = $request->input('next_step');
      $review->status = 2;
      $review->save();


      return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);

    }

    public function add_participants(Request $request)
    {

        $user = DiscussionParticipants::where('discussion_id',$request->input('discussion_id'))
            ->where('user_id',$request->input('user_id'))
            ->first()->exists();

        if($user==true)
        {

        }else {
          $record = new DiscussionParticipants();

          $record->discussion_id = $request->input('discussion_id');
          $record->user_id = $request->input('user_id');
          $record->save();
        }

        return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);
    }

    public function close_discussion(Request $request)
    {
      $record = Discussions::find($request->input('discussion_id'));

      $record->status = 2;
      $record->save();

      return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);
    }




}
