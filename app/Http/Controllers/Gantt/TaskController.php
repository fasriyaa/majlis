<?php
namespace App\Http\Controllers\Gantt;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\models\gantt\Task;
use App\models\timeline\Timeline;
use Redirect;
use Auth;

// use Session;

class TaskController extends Controller
{
    public function store(Request $request){

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
    }

    public function update($id, Request $request){
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
        $task = Task::find($id);
        $task->delete();

        return response()->json([
            "action"=> "deleted"
        ]);
    }


    public function add_subtask($id)
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
    }

    public function subitem_store(Request $request)
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
    }

    public function reorder_task($id)
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
    }

    public function sortorder(Request $request, $id, $index)
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

    }

    private function new_timeline($text, $task, $type)
    {
      $user_id = Auth::id();
      $new_timeline = Timeline::create(['text' => $text, 'task' => $task, 'user' => $user_id, 'type' => $type]);

    }


}
