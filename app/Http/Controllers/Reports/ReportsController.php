<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;

use App\models\meetings\Meetings;
use App\models\members\Members;
use App\models\meetings\Participants;
use App\models\timeline\Timeline;
use Illuminate\Http\Request;

use Auth;

class ReportsController extends Controller
{
    public function reports_1(){
      $permission = "View Meeting";
      if(auth()->user()->can($permission) == false)
      {
        abort(403);
      }

      $meetings = Meetings::with('member')
          ->with('participants')->orderBy('created_at', 'DESC')
          ->get();

          // return $meetings;
      return view('reports.reports_1',compact('meetings'));
    }

    public function reports_2($date){
      $permission = "View Meeting";
      if(auth()->user()->can($permission) == false){abort(403);}

      $meetings = Meetings::with('member')
          ->with('participants')->where('date', date("Y-m-d",strtotime($date)))->orderBy('created_at', 'DESC')
          ->get();
          // return $meetings;
      return view('reports.reports_2',compact('meetings'));
    }

    public function _reports_2(Request $request){
      $permission = "View Meeting";
      if(auth()->user()->can($permission) == false){abort(403);}

      $date = date("Y-m-d",strtotime($request->date));
      $meetings = Meetings::with('member')
          ->with('participants')->where('date', date("Y-m-d",strtotime($request->date)))->orderBy('created_at', 'DESC')
          ->get();
          // return $meetings;
      return view('reports.reports_2',compact('meetings','date'));
    }
}
