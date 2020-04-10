<?php

namespace App\Http\Controllers;


use App\models\gantt\Task;
use App\models\timeline\Timeline;
use App\models\taskApproval\TaskApproval;
use App\models\docs\RequireDoc;
use App\models\piu\piu;
use App\User;
use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{

  public function __construct()
  {
      $this->middleware('auth');
  }
    public function versionone()
    {


    }

    public function versiontwo()
    {
        // return view('dashboard.v2');
    }
    public function versionthree()
    {
        // return view('dashboard.v3');
    }

    public function livefeed()
    {
      $permission = "View Livefeed";
      if(auth()->user()->can($permission) == false)
      {
        abort(403);
      }
        //Getting feed from timeline
        $feeds = Timeline::select('text','updated_at','user_id','type','url')
            ->with('user:id,name,profile_pic')
            ->orderby('updated_at','DESC')
            ->limit(20)
            ->get();



        // return $feeds;
        return view('dashboard.livefeed',compact('feeds'));

    }

    public function critical()
    {


    }
}
