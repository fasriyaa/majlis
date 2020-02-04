<?php

namespace App\Http\Controllers\PIU;

use App\Http\Controllers\Controller;
use App\models\piu\piu;
use Illuminate\Http\Request;
use App\models\gantt\Task;
use App\models\timeline\Timeline;
use App\User;
use Auth;

class PiuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pius = piu::all();
        return view('piu.index', compact('pius'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('piu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $piu = piu::create($request->all());
        return redirect()->route('piu.index');
        // return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\piu  $piu
     * @return \Illuminate\Http\Response
     */
    public function show(piu $piu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\piu  $piu
     * @return \Illuminate\Http\Response
     */
    public function edit(piu $piu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\piu  $piu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, piu $piu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\piu  $piu
     * @return \Illuminate\Http\Response
     */
    public function destroy(piu $piu)
    {
        //
    }

    public function assign_piu($task_id, $piu_id)
    {
      $user_id = Auth::id();
      // updating Task Table
      $update_assign_piu = Task::Where('id', $task_id)->Update(['piu_id' => $piu_id]);

      // Updating Timeline
      //getting the staff
      $piu = piu::select('short_name')
        ->where('id','=',$piu_id)
        ->first();

      $text = "Assigned to ". $piu->short_name;
      $url = "/task/" . $task_id;

      $new_timeline = Timeline::create(['text' => $text, 'task' => $task_id, 'user' => $user_id, 'type'=>5, 'url' => $url]);
      return response()->json($new_timeline);
    }
}
