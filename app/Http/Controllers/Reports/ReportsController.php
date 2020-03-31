<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\models\budget\PV;
use App\models\Gantt\Task;

class ReportsController extends Controller
{
    public function index()
    {
      return view('reports.index');
    }
    public function reports($id)
    {
      if($id == 1)
      {
        $data = $this->report1();
        // return $data;
        return view('reports.1', compact('data'));
      }

      if($id == 2)
      {
        $data = $this->report2();


        $components = Task::where('parent', '=', 1)
              ->pluck('id');

        $components_text = Task::where('parent', '=', 1)
              ->pluck('text');
        // return $components;
        return view('reports.2', compact('data','components','components_text'));
      }

    }

    private function report1()
    {
      $data = PV::select('id','pv_no')
          ->with('invoice.contract.currencies')
          ->get();
      return $data;
    }
    private function report2()
    {
      $data = PV::select('id','pv_no')
          ->with('invoice.contract.currencies')
          ->with('invoice.contract.task.parent_pv.parent_pv.parent_pv.parent_pv')
          ->get();
      return $data;
    }

}
