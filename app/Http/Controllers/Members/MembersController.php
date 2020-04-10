<?php

namespace App\Http\Controllers\Members;

use App\Http\Controllers\Controller;

use App\models\members\Members;
use Illuminate\Http\Request;

class MembersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission = "View Members";
        if(auth()->user()->can($permission) == false)
        {
          abort(403);
        }
        $members = Members::all();
        return view('members.index',compact('members'));
    }
    public function create()
    {
        $permission = "Create Members";
        if(auth()->user()->can($permission) == false)
        {
          abort(403);
        }
        return view('members.create');
    }
    public function store(Request $request)
    {
      $permission = "Create Members";
      if(auth()->user()->can($permission) == false)
      {
        abort(403);
      }

      $member = new Members;
      $member->name = $request->name;
      $member->constituency = $request->constituency;
      $member->email = $request->email;
      $member->contact = $request->contact;
      $member->status = 1;
      $member->save();

      return redirect()->route('members.index');
    }
    public function show(Members $members)
    {
        //
    }
    public function edit($id)
    {
        $permission = "Edit Members";
        if(auth()->user()->can($permission) == false)
        {
          abort(403);
        }

        $member = Members::where('id',$id)
          ->first();

        return view('members.edit', compact('member'));
    }
    public function update(Request $request, $id)
    {
          $permission = "Edit Members";
          if(auth()->user()->can($permission) == false)
          {
            abort(403);
          }

          $member = Members::find($id);
          $member->name = $request->name;
          $member->constituency = $request->constituency;
          $member->email = $request->email;
          $member->contact = $request->contact;
          $member->status = 1;
          $member->save();

          return back()->with(['message' => "Member information upated", 'label' => "success"]);

    }
    public function destroy(Members $members)
    {
        //
    }
}
