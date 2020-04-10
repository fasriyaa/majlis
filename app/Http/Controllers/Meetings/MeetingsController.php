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

          $meetings = Meetings::all();
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
        //
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
