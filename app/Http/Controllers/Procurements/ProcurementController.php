<?php

namespace App\Http\Controllers\Procurements;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\models\gantt\Task;
use app\User;

class ProcurementController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function ongoing_procurements()
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

      $tasks = Task::select('id', 'text', 'progress','piu_id','procurement')
          ->whereIn('parent', $subact_id)
          ->where('procurement',1)
          ->with('piu:id,short_name')
          ->orderBy('progress', 'DESC')
          ->get();


      return view('procurements.ongoing', compact('tasks'));
    }

}
