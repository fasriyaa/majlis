<?php

namespace App\Http\Controllers;


use App\models\gantt\Task;
use Illuminate\Http\Request;

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

          $milestone = count($subactivities);
          $activities = count($tasks);

        return view('dashboard.v1', compact('milestone', 'activities'));
    }
    public function versiontwo()
    {
        return view('dashboard.v2');
    }
    public function versionthree()
    {
        return view('dashboard.v3');
    }
}
