<?php

namespace App\Http\Controllers\Budget;

use App\Http\Controllers\Controller;

use App\models\budget\Allocation;
use App\models\gantt\Task;

use Illuminate\Http\Request;

use Auth;

class AllocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $components = Task::where('parent',1)
          ->pluck('id');

      $subcomponents = Task::select('id', 'text')
          ->whereIn('parent', $components)
          ->with('allocations:task_id,base_allocation')
          ->get();

      // return $subcomponents;
      return view('budget.allocations', compact('subcomponents'));

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
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function show(Allocation $allocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $task = Task::select('id','text')
          ->where('id',$id)
          ->with('allocations:task_id,base_allocation')
          ->first();

        // return $task;
        return view('budget.edit_base_allocations', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

      //get the existing record from allocations table if any
      $allocation = Allocation::find($request->task_id);

      if($allocation == null)
      {
            $new_allocation = new Allocation;
            $new_allocation->task_id = $request->task_id;
            $new_allocation->base_allocation = $request->base_allocation;
            $new_allocation->save();
          }else {
            $allocation->base_allocation = $request->base_allocation;
            $allocation->save();
      }

      return redirect('allocations');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Allocation  $allocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Allocation $allocation)
    {
        //
    }
}