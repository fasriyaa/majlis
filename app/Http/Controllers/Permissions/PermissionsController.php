<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\models\modules\MainModules;
use App\User;
use Auth;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $permission = "View Permission";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }

            // return 1;

            $permissions = Permission::with('module:id,name')
                ->with('roles')
                ->get();

            return view('permissions.index', compact('permissions'));

    }
    public function create()
    {
      // $permission = "Create Permission";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
            //geting modules
            $modules = MainModules::select('id','name')
                ->get();

            return view('permissions.create',compact('modules'));
    }
    public function store(Request $request)
    {
      // $permission = "Create Permission";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
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

    }
    public function show(Permissions $permissions)
    {

    }
    public function edit($id)
    {
        // $permission = "Edit Permission";
        // if(auth()->user()->can($permission) == false)
        // {
        //   abort(403);
        // }
            $permissions = Permission::select('id','name','module_id')
                ->find($id);

            //geting modules
            $modules = MainModules::select('id','name')
                ->get();

            // return $role;
            return view('permissions.edit',compact('permissions','modules'));
    }
    public function update(Request $request, $id)
    {
          // $permission = "Edit Permission";
          // if(auth()->user()->can($permission) == false)
          // {
          //   abort(403);
          // }
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
    }
    public function destroy(Permissions $permissions)
    {
        //
    }

    public function assign_permission($role_id,$permission_id)
    {
      // $permission = "Assign Permission";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
            $role = Role::FindById($role_id);
            $permission = Permission::Find($permission_id);
            $role->givePermissionTo($permission);

            return redirect()->route('permissions.index');

    }
    public function assign_role($user_id,$role_id)
    {
      // $permission = "Assign Role";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
            $role = Role::FindById($role_id);
            $user = User::FindOrFail($user_id);
            $user->assignRole($role->name);

            return redirect()->route('permissions.index');

    }
    public function attach_role($id)
    {
      // $permission = "Assign Role to Permission";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }
              $permissions = Permission::with('roles')
                  ->with('module:id,name')
                  ->find($id);
              $roles = Role::select('id','name')
                  ->get();
              return view('permissions.attach_role',compact('roles', 'permissions'));

    }
    public function attach_role_store(Request $request)
    {
      // $permission = "Assign Role to Permission";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }
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

    }
}
