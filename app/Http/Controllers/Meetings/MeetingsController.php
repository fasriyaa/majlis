<?php

namespace App\Http\Controllers\Meetings;

use App\Http\Controllers\Controller;

use App\models\meetings\Meetings;
use App\models\members\Members;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
          $permission = "View Meeting";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $meetings = Meetings::with('member')
              ->get();

              // return $meetings;
          return view('meetings.index',compact('meetings'));
    }
    public function create()
    {
          $permission = "Create Meeting";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $members = Members::all();
          return view('meetings.create', compact('members'));
    }
    public function store(Request $request)
    {
          $permission = "Create Meeting";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $xrecord = Meetings::where('member_id', $request->member_id)
              ->where('meeting_time', date('Y-m-d H:i', strtotime($request->date)))
              ->first();

            if($xrecord)
            {
              abort(400);
            }

          $meeting = new Meetings;
          $meeting->member_id = $request->member_id;
          $meeting->date = date('Y-m-d', strtotime($request->date));
          $meeting->meeting_time = date('Y-m-d H:i', strtotime($request->date));
          $meeting->duration = $request->duration;
          $meeting->status = 1;
          $meeting->save();

          return redirect()->route('meetings.index');
    }
    public function show(Meetings $meetings)
    {
        //
    }
    public function edit(Meetings $meetings)
    {
        //
    }
    public function update(Request $request, Meetings $meetings)
    {
        //
    }
    public function destroy(Meetings $meetings)
    {
        //
    }
}
