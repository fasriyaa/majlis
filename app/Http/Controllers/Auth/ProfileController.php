<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

use App\models\piu\piu;

use App\User;
use Auth;

class ProfileController extends Controller
{
  use FileUploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = Auth::id();
        $user = User::select('id','name','email','profile_pic','designation','organization','department as piu_id')
            ->where('id',$user_id)
            ->with('piu:id,short_name')
            ->first();

        $pius = piu::select('id','short_name')
            ->get();

        // return $pius;
        return view('auth.profile',compact('user','pius'));

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return $id;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $request;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload_profile_pic(Request $request)
    {
      $user_id = Auth::id();

      $request = $this->saveFiles($request);

      $url = "/files/" . $request->input('file');

      $update_profile = User::Where('id', $user_id)->Update(['profile_pic' => $url]);


      return redirect('/profile');
    }

    public function update_profile(Request $request)
    {
      $user_id = Auth::id();

      $user = User::find($user_id);

      $user->organization = $request->organization ?? null;
      $user->designation = $request->designation ?? null;
      $user->department = $request->department ?? null;
      $user->save();

      // return $user;
      return redirect('/profile');
    }

}
