<?php
namespace App\Http\Controllers\Gantt;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\models\gantt\Task;
use App\models\timeline\Timeline;
use App\models\budget\budget;
use App\models\budget\Allocation;
use Redirect;
use Auth;
use Session;

// use Session;

class TaskController extends Controller
{
    public function store(Request $request){
      $permission = "Create Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $task = new Task();

        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->sortorder = Task::max("sortorder") + 1;

        $task->save();


        return response()->json([
            "action"=> "inserted",
            "tid" => $task->id
        ]);
          }else {
            return view($err_url);
      }
    }

    public function update($id, Request $request){
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $task = Task::find($id);

        $task->text = $request->text;
        $task->start_date = $request->start_date;
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;

        $task->save();

        if($request->has("target")){
        $this->updateOrder($id, $request->target);
        }

        return response()->json([
            "action"=> "updated"
        ]);
          }else {
            return view($err_url);
      }
    }

    private function updateOrder($taskId, $target){
        $nextTask = false;
        $targetId = $target;

        if(strpos($target, "next:") === 0){
            $targetId = substr($target, strlen("next:"));
            $nextTask = true;
        }

        if($targetId == "null")
            return;

        $targetOrder = Task::find($targetId)->sortorder;
        if($nextTask)
            $targetOrder++;

        Task::where("sortorder", ">=", $targetOrder)->increment("sortorder");

        $updatedTask = Task::find($taskId);
        $updatedTask->sortorder = $targetOrder;
        $updatedTask->save();
    }

    public function destroy($id){
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            "action"=> "deleted"
        ]);
          }else {
            return view($err_url);
      }
    }


    public function add_subtask($id)
    {
      $permission = "Create Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        // set url session
        $task_url = url()->previous();
        $task_url = session(['task_url' => $task_url]);


        //get task detials
        $task = Task::select('id','text')
            ->where('id',$id)
            ->first();

        // return $url;
        return view('gantt.create_subtask', compact('task'));
          }else {
            return view($err_url);
      }
    }

    public function edit_subtask($id)
    {
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        // set url session
        $task_url = url()->previous();
        $task_url = session(['task_url' => $task_url]);

        $level = $this->task_level($id);


        //get task detials
        $task = Task::select('id','text','start_date','duration','procurement')
            ->where('id',$id)
            ->with('budget:task_id,budget')
            ->first();

        // return $task;
        return view('gantt.edit_subtask', compact('task','level'));
            }else {
              return view($err_url);
      }
    }

    public function subitem_store(Request $request)
    {
      $permission = "Create Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $task = new Task();

        $task->text = $request->name;
        $task->start_date = date("Y-m-d", strtotime($request->start_date));
        $task->duration = $request->duration;
        $task->progress = $request->has("progress") ? $request->progress : 0;
        $task->parent = $request->parent;
        $task->sortorder = Task::max("sortorder") + 1;

        $task->save();

        //create timeline record
        $text = "New Task Created";
        $type = 3; // for creating new task
        $this->new_timeline($text, $task->id, $type);

        $task_url = session('task_url');
        return Redirect::to($task_url);
        // return $task->id;
          }else {
            return view($err_url);
      }
    }

    public function subitem_edit(Request $request)
    {
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        $task = Task::find($request->input('parent'));

        $task->text = $request->name;
        $task->start_date = date("Y-m-d", strtotime($request->start_date));
        $task->duration = $request->duration;

        if($request->has('procurement'))
          {
            $task->procurement = 1;
          }
          else {
            $task->procurement = 0;
          }

        $task->save();

        //create timeline record
        $text = "Task Edited";
        $type = 3; // for creating new task
        $this->new_timeline($text, $task->id, $type);

        //checking and saving budget entry
        $budget_id = budget::select('id')
            ->where('task_id',$task->id)
            ->first();

        $budget = budget::find($budget_id['id']);

        $allocation = 0;
        $subactivity_id = Task::where('id',$task->id)
              ->pluck('parent');
        $activity_id = Task::where('id',$subactivity_id)
              ->pluck('parent');
        $subcomponent_id = Task::where('id',$activity_id)
              ->pluck('parent');
        $allocation = Allocation::select('base_allocation')
            ->where('task_id', $subcomponent_id)
            ->first();

        $activities_id = Task::where('parent',$subcomponent_id)
            ->pluck('id');
        $subactivities_id = Task::whereIn('parent',$activities_id)
            ->pluck('id');
        $tasks_id = Task::whereIn('parent',$subactivities_id)
            ->pluck('id');

        $allocated = budget::select('budget')
            ->whereIn('task_id',$tasks_id)
            ->get()->sum('budget');


        $old_budget = $budget->budget ?? 0;
        $allocated = $allocated - $old_budget + $request->budget;
        $dif = $allocated - $allocation['base_allocation'];


        if($allocated > $allocation['base_allocation'])
        {
            $error = "Exceeds subcomponent allocations by USD ". number_format($dif);
            // $task_url = session('task_url');
            // return Redirect::to($task_url);
            // return $error;
            Session::flash('error', $error);
            return back();
        }else{
              if($budget == null)
              {
                  $new_budget = new budget;
                  $new_budget->task_id = $task->id;
                  $new_budget->budget = $request->budget;
                  $new_budget->status = 1;
                  $new_budget->save();

                  $text = "Entered a new budget figure: USD ". number_format($new_budget->budget);
                  $type = 9;
                  $this->new_timeline($text, $task->id, $type);

                  // return "no existing budget";

               }elseif($budget->budget == $request->budget){
                    // No need to do anything
                    // return "budget found but same";
                    }else {
                    $old_budget = $budget->budget;
                    $budget->budget = $request->budget;
                    $budget->save();

                    $text = "Budget figure revised from USD ". number_format($old_budget). " to USD ". number_format($budget->budget);
                    $type = 9;
                    $this->new_timeline($text, $task->id, $type);

                    // return "need to revise budget";
                }
        }


        // return $budget;

        $task_url = session('task_url');
        return Redirect::to($task_url);
          }else {
            return view($err_url);
      }
    }

    public function reorder_task($id)
    {
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        // set url session
        $task_url = url()->previous();
        $task_url = session(['task_url' => $task_url]);


        //get task detials
        $task = Task::select('id','text')
            ->where('id',$id)
            ->first();

        $sub_items = Task::select('id','text','sortorder')
            ->where('parent',$id)
            ->orderby('sortorder','ASC')
            ->get();

        // return $sub_items;
        return view('gantt.reorder_task', compact('task','sub_items'));
          }else {
            return view($err_url);
      }
    }

    public function sortorder(Request $request, $id, $index)
    {
      $permission = "Edit Task";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
        //get sub items in existing orderby
        $parent = Task::where('id',$id)
              ->pluck('parent');

        $sub_items = Task::select('id')
                ->where('parent',$parent)
                ->orderby('sortorder')
                ->get()->toArray();

        // $index = $index+1;
        $target_id = $sub_items[$index]['id'];
        $this->updateOrder($id,$target_id);

        return response()->json([
            "action"=> "updated"
        ]);
          }else {
            return view($err_url);
      }
    }

    private function new_timeline($text, $task, $type)
    {
      $user_id = Auth::id();
      $new_timeline = Timeline::create(['text' => $text, 'task' => $task, 'user' => $user_id, 'type' => $type]);

    }

    private function task_level($id)
    {
      $level = Task::select('parent')
          ->where('id',$id)
          ->first();

      $count = 1;
      while($level['parent'] > 1){
        $level = Task::select('parent')
              ->where('id',$level['parent'])
              ->first();
        $count++;
      }

      return $count;
    }


}
