<?php

namespace App\Http\Controllers\Meetings;

use App\Http\Controllers\Controller;

use App\models\meetings\Meetings;
use App\models\members\Members;
use App\models\meetings\Participants;
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
              ->with('participants')
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

    public function close($id)
    {
          $permission = "Close Meeting";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $meeting = Meetings::find($id);
          if($meeting->status != 1)
          {
            abort(411);
          }

          $meeting->status = 2;
          $meeting->save();

          return back();
    }
    public function open($id)
    {
          $permission = "Open Meeting";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $meeting = Meetings::find($id);
          if($meeting->status != 2)
          {
            abort(411);
          }

          $meeting->status = 1;
          $meeting->save();

          return back();
    }
    public function add_participants($id)
    {
          $permission = "Add Participants";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }
          $meeting = Meetings::with('member')
              ->with('participants')
              ->find($id);

      // return $meeting;
      return view('meetings.add_participants', compact('meeting'));
    }
    public function store_participants(Request $request)
    {

          $permission = "Add Participants";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }
          $xrecord = Participants::where('id_no', $request->id_no)
              ->first();
            if($xrecord)
            {
              return back()->with(['message' => "Participant already exist", 'label' => "danger"]);
            }

        $participant = new Participants;
        $participant->meeting_id = $request->meeting_id;
        $participant->name = $request->name;
        $participant->id_no = $request->id_no;
        $participant->contact = $request->contact;
        $participant->save();

      return back()->with(['message' => "Participant saved", 'label' => "success"]);
    }
    public function remove_participants($id)
    {
          $permission = "Remove Participants";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

        $participant = Participants::find($id);
        $participant->delete();
        return back()->with(['message' => "Participant Removed", 'label' => "success"]);
    }
}
