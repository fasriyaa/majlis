<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\models\modules\MainModules;
use App\User;

class PermissionsController extends Controller
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
            $permissions = Permission::with('module:id,name')
                ->with('roles')
                ->get();

            // $roles = Permission::with('roles')->get();

            // return $permissions;

            return view('permissions.index', compact('permissions'));
            }else {

              // return 403
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
            //geting modules
            $modules = MainModules::select('id','name')
                ->get();

            return view('permissions.create',compact('modules'));
            }else {
              return view('layouts.exceptions.403');
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
            $existing_record_check = Permission::select('id')
              ->where('name',$request->name)
              ->first();

              if($existing_record_check == null)
              {
                  $permissions = Permission::create($request->all());

              }else {
                return back()->with(['message' => "Permission name exist", 'label' => "danger"]);
              }

                return redirect()->route('permissions.index');
              }else {
                //return 403
                return view('layouts.exceptions.403');
              }
      // return $existing_record_check;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function show(Permissions $permissions)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $permission = "default";
        if(auth()->user()->can($permission) == true)
        {
            $permissions = Permission::select('id','name','module_id')
                ->find($id);

            //geting modules
            $modules = MainModules::select('id','name')
                ->get();

            // return $role;
            return view('permissions.edit',compact('permissions','modules'));

            }else {
              // return error page
              return view('layouts.exceptions.403');

            }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
          $permission = "default";
          if(auth()->user()->can($permission) == true)
          {
              //getting the role
              $permissions = Permission::find($id);

                if($permissions['name']==$request->name and $permissions['module_id']==$request->module_id)
                {
                    return back()->with(['message' => "No Change", 'label' => "warning"]);
                    }else {

                          $permissions->name = $request->name;
                          $permissions->module_id = $request->module_id;
                          $permissions->save();
                          return redirect()->route('permissions.index')->with(['message' => "Record Upated", 'label' => "success"]);
                }

            }else {
                return back()->with(['message' => "You do not have required permission", 'label' => "danger"]);
          }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permissions $permissions)
    {
        //
    }

    public function assign_permission($role_id,$permission_id)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
            $role = Role::FindById($role_id);
            $permission = Permission::Find($permission_id);
            $role->givePermissionTo($permission);

            return redirect()->route('permissions.index');
            }else {
              // return 403
              return view('layouts.exceptions.403');

            }

    }

    public function assign_role($user_id,$role_id)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
      {
            $role = Role::FindById($role_id);
            $user = User::FindOrFail($user_id);
            $user->assignRole($role->name);

            return redirect()->route('permissions.index');
            }else {
              // return 403
              return view('layouts.exceptions.403');
            }
    }

    public function attach_role($id)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
              $permissions = Permission::with('roles')
                  ->with('module:id,name')
                  ->find($id);
              $roles = Role::select('id','name')
                  ->get();
              return view('permissions.attach_role',compact('roles', 'permissions'));
              }else {
                return view('layouts.exceptions.403');
              }

    }

    public function attach_role_store(Request $request)
    {
      $permission = "default";
      if(auth()->user()->can($permission) == true)
          {
                //removing existing roles from the permissoin
                $permissions = Permission::with('roles:id,name')
                    ->find($request->permission_id);

                //revoking old roles
                foreach($permissions->roles as $role)
                {
                    $role->revokePermissionTo($permissions->id);
                }

                //giving new roles
                if($request->has('roles_id'))
                {
                    foreach($request->roles_id as $role_id)
                      {
                          $role = Role::find($role_id);
                          $role->givePermissionTo($permissions->id);
                      }
                }
                return redirect()->route('permissions.index');
                }else {
                  // 403
                  return view('layouts.exceptions.403');
          }

    }
}
