<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

use Auth;

class RolesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
            $roles = Role::with('permissions')->get();
            return view('roles.index', compact('roles'));

            }else {
            // return view('layouts.403');
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
          return view('roles.create');
          }else {
            // return error page;
      }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
        $existing_record_check = Role::select('id')
          ->where('name',$request->name)
          ->first();

          if($existing_record_check == null)
          {
                $role = Role::create($request->all());
                return redirect()->route('roles.index');

                }else {
                    return back()->with(['message' => "Role exist", 'label' => "danger"]);
          }

          }else {
            return back()->with(['message' => "You do not have required permission", 'label' => "danger"]);
      }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function show(Roles $roles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function edit($roles)
    {

      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
          $role = Role::select('id','name')
              ->find($roles);

          // return $role;
          return view('roles.edit',compact('role'));

          }else {
            // return error page
          }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role_id)
    {
        $permission = "default";
        if(auth()->user()->can($permission) == true)
        {
            //getting the role
            $role = Role::find($role_id);

              if($role['name']==$request->name)
              {
                  return back()->with(['message' => "No Change", 'label' => "warning"]);
                  }else {

                        $role->name = $request->name;
                        $role->save();
                        return redirect()->route('roles.index')->with(['message' => "Record Upated", 'label' => "success"]);
              }



          }else {
              return back()->with(['message' => "You do not have required permission", 'label' => "danger"]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Roles  $roles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Roles $roles)
    {
        //
    }

    public function attach_permission($id)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
              $role = Role::with('permissions')
                  // ->with('module:id,name')
                  ->find($id);
              $permissions = Permission::select('id','name')
                  ->get();
              // return $role;
              return view('roles.attach_permission',compact('role', 'permissions'));
              }else {
                return view('layouts.exceptions.403');
              }
    }

    public function attach_permission_store(Request $request)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
                //removing existing permission from the role
                $role = Role::with('permissions:id,name')
                    ->find($request->role_id);

                //revoking old permissions
                foreach($role->permissions as $permissions)
                {
                    $role->revokePermissionTo($permissions['id']);
                }

                //giving new permissions
                if($request->has('permission_id'))
                {
                    foreach($request->permission_id as $permission_id)
                      {
                          // $role = Role::find($role_id);
                          $role->givePermissionTo($permission_id);
                      }
                }
                return redirect()->route('roles.index');
                }else {
                  // 403
                  return view('layouts.exceptions.403');
          }

    }

    public function attach_user($id)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
              $user = User::where('id',$id)
                  ->with('roles')->first();

              $roles = Role::all();
              return view('roles.attach_user',compact('roles','user'));
              }else {
                return view('layouts.exceptions.403');
              }
    }

    public function attach_user_store(Request $request)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
                
                $user = User::find($request->user_id);
                $user->syncRoles($request->roles_id);
                // return $request;
                return redirect()->route('users');
                }else {
                  // 403
                  return view('layouts.exceptions.403');
          }

    }

}
