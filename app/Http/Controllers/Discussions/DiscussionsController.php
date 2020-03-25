<?php

namespace App\Http\Controllers\Discussions;

use App\Http\Controllers\Controller;
use App\models\discussions\Discussions;
use Illuminate\Http\Request;

use App\models\gantt\Task;
use App\models\discussions\TaskDiscussions;
use App\models\discussions\DiscussionAgenda;
use App\models\discussions\DiscussionParticipants;
use App\models\discussions\Snooz;
use App\models\docs\RequireDoc;
use App\models\piu\piu;
use App\models\timeline\Timeline;
use App\User;
use URL;
use Auth;


class DiscussionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            $permission = "View PMU Meetings";
            $err_url = "layouts.exceptions.403";
            if(auth()->user()->can($permission) == true)
            {
              //PMU Discussions
              $pmu_lists = Discussions::select('id','created_at','status')
                  ->where('type',3)
                  ->orderby('id','DESC')
                  ->get();
              return view('discussions.pmu_daily_list',compact('pmu_lists'));
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
      $permission = "Create PMU Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $discussion = new Discussions();

            $discussion->type = $request->input('type');
            $discussion->status = 1; //1 for open

            $discussion->save();

            if($request->input('type') == 3)
            {
                $data = $this->discussion_task($discussion->id,3,0);
            }
            return redirect()->route('pmu_daily_list.index');
            // return $data;
          }else {
            return view($err_url);
      }
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

    private function discussion_task($id, $discussion_cat_id, $piu_id)
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


      if($discussion_cat_id == 1)
      {
        $tasks_id = Task::select('id','progress')
            ->whereIn('parent', $subact_id)
            ->get();
      }
      if($discussion_cat_id == 2)
      {
        $tasks_id = Task::select('id','progress')
            ->whereIn('parent', $subact_id)
            ->get();
      }
      if($discussion_cat_id == 3)
      {
        $tasks_id = Task::select('id','progress')
            ->whereIn('parent', $subact_id)
            ->get();
      }
      if($discussion_cat_id == 4)
      {
        $tasks_id = Task::select('id','progress')
            ->whereIn('parent', $subact_id)
            ->where('piu_id', $piu_id)
            ->get();
      }
      // if EXCO review
      if($discussion_cat_id == 5)
      {
        $tasks_id = Task::select('id','progress')
            ->whereIn('parent', $subact_id)
            ->where('procurement',1)
            ->get();
      }





      //storing the relevent ids to array

      foreach ($tasks_id as $task_id) {

        $subtasks = Task::select('id','start_date','duration')
            ->where('parent', $task_id->id)
            ->where('progress','<',1)
            ->orderby('sortorder','ASC')
            ->first();

          $snooz = Snooz::select('end_date')
              ->where('task_id', $subtasks['id'])
              ->where('discussion_cat_id', $discussion_cat_id)
              ->orderby('end_date','DESC')
              ->first();


            if($subtasks['id'] != null)
              if(date('Y-m-d')>$snooz['end_date'])
              {
                {
                  $task_dis = new TaskDiscussions();
                  $task_dis->discussion_id = $id;
                  $task_dis->task_id = $subtasks['id'];
                  $task_dis->progress = $task_id->progress;
                  $task_dis->last_due = date('Y-m-d', strtotime($subtasks['start_date'] . ' + ' . $subtasks['duration'] . ' day'));

                  $task_dis->save();
                }
              }

      }


      // return $snooz;
      return 3; // for pmu daily meetings



    }

    public function pmu_daily_meeting($id)
    {
      $permission = "View Review Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
            {
              //Getting Discussion Status
              $discussion_status = Discussions::select('id','status','piu_id','type','updated_at')
                    ->where('id',$id)
                    ->with('piu:id,short_name')
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

              if(isset($next_item->task_id))
              {
                    $next_item_prev = TaskDiscussions::select('comment','next_step','created_at')
                        ->where('task_id',$next_item->task_id)
                        ->where('status',2)
                        ->orderby('updated_at','DESC')
                        ->first();
              }else {
                $next_item_prev = null;
              }


              //getting assinged staff
              if(isset($next_item->task_id))
              {
                    $assinged_staff = User::select('name')
                        ->where('id',$next_item->task['staff'])
                        ->first();
              }else{
                $assinged_staff = null;
              }


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



                // return $discussion_status;
              return view('discussions.pmu_daily_meeting',compact('subtasks','discussion_status','next_item','users','participants','docs','assinged_staff','next_item_prev'));
            }else {
              return view($err_url);
      }
    }

    public function review(Request $request)
    {
      $permission = "Review Meeting items";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $review = TaskDiscussions::find($request->input('id'));

        $review->comment = $request->input('status');
        $review->next_step = $request->input('next_step');
        $review->status = 2;
        $review->save();

        // Record in snooz if defined
        if($request->has("snooz"))
        {
          $new_snooz = new Snooz();

          $new_snooz->task_id = $request->input('task_id');
          $new_snooz->discussion_id = $request->input('discussion_id');
          $new_snooz->discussion_cat_id = $request->input('discussion_cat_id');
          $new_snooz->start_date = date('Y-m-d');
          $new_snooz->end_date = Date('Y-m-d', strtotime("+".$request->input('snooz')." days"));

          $new_snooz->save();
        }

        return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);
          }else {
            return view($err_url);
      }
    }

    public function new_comment(Request $request)
    {
      $permission = "Review Meeting items";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $new_comment = new TaskDiscussions;

            $new_comment->comment = $request->input('status');
            $new_comment->next_step = $request->input('next_step');
            $new_comment->status = 2;
            $new_comment->discussion_id = $request->discussion_id;
            $new_comment->task_id = $request->task_id;
            $new_comment->save();

            //time line entry
            $url = "/task_timeline/" . $new_comment->task_id;
            $text = "New comment: ". $new_comment->comment;
            $this->new_timeline(8, $new_comment->task_id, $url, $text);

            // return $new_comment;

            return redirect()->route('pmu.task_timeline', [$request->input('task_id')]);
          }else {
            return view($err_url);
      }
  }



    public function add_participants(Request $request)
    {
      $permission = "Review Meeting items";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
              $user = DiscussionParticipants::where('discussion_id',$request->input('discussion_id'))
                  ->where('user_id',$request->input('user_id'))
                  ->first();

              if(isset($user->id))
              {

              }else {
                $record = new DiscussionParticipants();

                $record->discussion_id = $request->input('discussion_id');
                $record->user_id = $request->input('user_id');
                $record->save();
              }

              if($request->input('discussion_type') == 6)
                {
                  return redirect()->route('sc.view', [$request->input('discussion_id')]);
                }else{
                  return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);
              }
            }else {
              return view($err_url);
      }
    }

    public function close_discussion(Request $request)
    {
      $permission = "Review Meeting items";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
                $record = Discussions::find($request->input('discussion_id'));

                $record->status = 2;
                $record->save();

                //time line entry
                $url = "/pmu_daily_meeting/" . $request->input('discussion_id');
                $text = "";
                $this->new_timeline(4, $request->input('discussion_id'), $url, $text);

                // return $record;
                if($request->discussion_type == 6)
                {
                    return redirect()->route('sc.view', [$request->input('discussion_id')]);
                    }else{
                      return redirect()->route('pmu.daily.meeting', [$request->input('discussion_id')]);
                    }
            }else {
              return view($err_url);
      }
    }

    public function piu_review_list()
    {
      $permission = "View Review Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
              $piu_lists = Discussions::select('id','piu_id','created_at','status')
                  ->where('type',4)
                  ->with('piu:id,short_name')
                  ->orderby('id','DESC')
                  ->get();

              $pius = piu::all();

                  // return $piu_lists;
              return view('discussions.piu_review_list',compact('piu_lists','pius'));
            }else {
              return view($err_url);
      }
    }

    public function piu_review_list_store(Request $request)
    {
      $permission = "Create PIU Review Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $discussion = new Discussions();

            $discussion->type = $request->input('type');
            $discussion->piu_id = $request->input('piu_id');
            $discussion->status = 1; //1 for open

            $discussion->save();


            $data = $this->discussion_task($discussion->id,4,$request->input('piu_id'));

            return redirect()->route('piu.review_list');
          }else {
            return view($err_url);
      }
    }

    public function piu_review_meeting($id)
    {
      $permission = "Review Meeting items";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
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

        if(isset($next_item->task_id))
        {
              $next_item_prev = TaskDiscussions::select('comment','next_step')
                  ->where('task_id',$next_item->task_id)
                  ->where('status',2)
                  ->orderby('updated_at','DESC')
                  ->first();
        }else {
          $next_item_prev = null;
        }


        //getting assinged staff
        if(isset($next_item->task_id))
        {
              $assinged_staff = User::select('name')
                  ->where('id',$next_item->task['staff'])
                  ->first();
        }else{
          $assinged_staff = null;
        }


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
        return view('discussions.piu_review_meeting',compact('subtasks','discussion_status','next_item','users','participants','docs','assinged_staff','next_item_prev'));
          }else {
            return view($err_url);
      }
    }

    private function new_timeline($var1, $var2, $url, $text)
    {
      $user_id = Auth::id();

      //var1 is type, 4 for PIU review meetings
      if($var1 == 4)
      {
        $piu_id = Discussions::select('piu_id')
            ->where('id',$var2)
            ->first();

        $piu_name = piu::select('short_name')
            ->where('id',$piu_id['piu_id'])
            ->first();

        $text = "Held a Review Meeting with ". $piu_name['short_name'];
      }



      $new_timeline = Timeline::create(['text' => $text, 'task' => $var2, 'user' => $user_id, 'type' => $var1, 'url' => $url]);
      return response()->json($new_timeline);
    }

    public function exco_list()
    {
      $permission = "View EXCO Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $exco_lists = Discussions::select('id','piu_id','created_at','status')
                ->where('type',5)
                ->with('piu:id,short_name')
                ->orderby('id','DESC')
                ->get();

            //getting previous meetings
            $previous_meetings = Discussions::select('id','created_at')
                ->where('type',5)
                ->orderBy('created_at','DESC')
                ->get();

              // return $previous_meetings;
            return view('discussions.exco_review_list',compact('exco_lists','previous_meetings'));
          }else {
            return view($err_url);
      }
    }

    public function exco_review_list_store(Request $request)
    {
      $permission = "Create EXCO Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $discussion = new Discussions();

            $discussion->type = $request->input('type');
            $discussion->piu_id = $request->input('piu_id');
            $discussion->last_meeting = $request->input('last_meeting');
            $discussion->status = 1; //1 for open

            $discussion->save();


            $data = $this->discussion_task($discussion->id,$discussion->type,$request->input('piu_id'));

            return redirect()->route('exco.list');
            }else {
              return view($err_url);
      }
    }

    public function exco_view($id)
    {
      $permission = "View EXCO Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $discussion = Discussions::select('id','last_meeting','type','updated_at')
            ->where('id',$id)
            ->first();

        //get tasks
        $sub_tasks_id = TaskDiscussions::where('discussion_id', $id)
            ->pluck('task_id');

        $tasks = Task::select('id','text','progress','start_date','duration','parent as parent_id','id as task_id')
            ->whereIn('id',$sub_tasks_id)
            ->with('parent:id,text,progress,piu_id')
            ->with('comments:task_id,id,comment')
            ->get();

        $last_discussion = Discussions::select('id','updated_at')
            ->where('id',$discussion['last_meeting'])
            ->first();

        $last_sub_tasks_id = TaskDiscussions::where('discussion_id', $discussion['last_meeting'])
            ->pluck('task_id');

        $last_tasks = Task::select('id','text','progress','start_date','duration','parent as parent_id','id as task_id')
            ->whereIn('id',$last_sub_tasks_id)
            ->with('parent:id,text,progress,piu_id')
            ->with('comments:task_id,id,comment,discussion_id,progress,last_due')
            ->get();
        return view('discussions.exco_view', compact('discussion','tasks','last_discussion','last_tasks'));
          }else {
            return view($err_url);
      }
    }

    public function sc_list()
    {
      $permission = "View SC Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $sc_lists = Discussions::select('id','meeting_date','created_at','status')
            ->where('type',6)
            ->orderby('id','DESC')
            ->get();

          // return $previous_meetings;
        return view('discussions.sclist',compact('sc_lists'));
          }else {
            return view($err_url);
      }
    }

    public function sc_list_store(Request $request)
    {
      $permission = "Create SC Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $discussion = new Discussions();

            $discussion->type = $request->input('type');
            $discussion->meeting_date = date("Y-m-d", strtotime($request->input('meeting_date')));
            $discussion->last_meeting = $request->input('last_meeting');
            $discussion->status = 1; //1 for open

            $discussion->save();
            // return $discussion;

            return redirect()->route('sc.list');
            }else {
              return view($err_url);
      }
    }

    public function sc_view($id)
    {
      $permission = "View SC Meetings";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $discussion = Discussions::select('id','meeting_date','type','status')
            ->where('id',$id)
            ->first();

        $agendas = DiscussionAgenda::select('description','submitter_type','submitter_id as staff', 'submitter_id as piu_id')
            ->where('discussion_id',$id)
            ->with('user:id,name')
            ->with('piu:id,short_name')
            ->get();

        //get piu list
        $pius = piu::select('id','short_name')
          ->get();

        $users = User::select('id','name')
          ->get();

        $participants = DiscussionParticipants::select('user_id')
            ->where('discussion_id',$id)
            ->with('user:id,name')
            ->get();

        $docs = RequireDoc::select('doc_name','alias_name','doc_date','req_doc_type')
            ->where('task_id',$id)
            ->where('req_doc_type', 2)
            ->get();

        $mins = RequireDoc::select('doc_name','req_doc_type')
            ->where('task_id',$id)
            ->where('req_doc_type', 3)
            ->get();
        // return $mins;
        return view('discussions.sc',compact('discussion','pius','users','agendas','participants','docs','mins'));
            }else {
              return view($err_url);
      }

    }


}
