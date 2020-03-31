<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\FileUploadTrait;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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
    public function change_password(Request $request)
    {
      if(Auth::Check())
            {
                  $request_data = $request->All();
                  $validator = $this->admin_credential_rules($request_data);
                  if($validator->fails())
                  {
                    return response()->json(array('error' => $validator->getMessageBag()->toArray()), 400);
                  }
                  else
                  {
                    $current_password = Auth::User()->password;
                    if(Hash::check($request_data['current_password'], $current_password))
                    {
                      $user_id = Auth::User()->id;
                      $obj_user = User::find($user_id);
                      $obj_user->password = Hash::make($request_data['password']);
                      $obj_user->save();
                      return redirect()->route('profile.index')->with(['message' => "Password Changed", 'label' => "success"]);
                    }
                    else
                    {
                      $error = array('current_password' => 'Please enter correct current password');
                      return response()->json(array('error' => $error), 400);
                    }
                  }
                }
                else
                {
                  abort(403);
                }
    }
    public function reset_password($id)
    {
      $permission = "Reset Password";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }
      return view('auth.reset_password', compact('id'));
    }
    public function store_password(Request $request)
    {
      $permission = "Reset Password";
      if(auth()->user()->can($permission) != true)
      {
        abort(403);
      }

      $user = User::find($request->user_id);
      $user->password = Hash::make($request->new_password);
      $user->save();

      // return $request;
      return redirect()->route('users');
    }

    private function admin_credential_rules(array $data)
        {
          $messages = [
            'current_password.required' => 'Please enter current password',
            'password.required' => 'Please enter password',
          ];

          $validator = Validator::make($data, [
            'current_password' => 'required',
            'password' => 'required|same:password',
            'confirm_password' => 'required|same:password',
          ], $messages);

          return $validator;
        }

}
