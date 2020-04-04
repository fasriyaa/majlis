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

      // $permission = "View Roles";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
            $roles = Role::with('permissions')->get();
            return view('roles.index', compact('roles'));
    }
    public function create()
    {
      // $permission = "Create Roles";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
          return view('roles.create');
    }
    public function store(Request $request)
    {
      // $permission = "Create Roles";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
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

    }
    public function show(Roles $roles)
    {
        //
    }
    public function edit($roles)
    {

      // $permission = "Edit Roles";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
          $role = Role::select('id','name')
              ->find($roles);

          // return $role;
          return view('roles.edit',compact('role'));

    }
    public function update(Request $request, $role_id)
    {
        // $permission = "Edit Roles";
        // if(auth()->user()->can($permission) == false)
        // {
        //   abort(403);
        // }
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

    }
    public function destroy(Roles $roles)
    {
        //
    }


    public function attach_permission($id)
    {
      // $permission = "Assign Permission";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }
              $role = Role::with('permissions')
                  // ->with('module:id,name')
                  ->find($id);
              $permissions = Permission::select('id','name')
                  ->get();
              // return $role;
              return view('roles.attach_permission',compact('role', 'permissions'));
    }
    public function attach_permission_store(Request $request)
    {
      // $permission = "Assign Permission";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }
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
    }
    public function attach_user($id)
    {
      // $permission = "Assign a Role to User";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }
              $user = User::where('id',$id)
                  ->with('roles')->first();

              $roles = Role::all();
              return view('roles.attach_user',compact('roles','user'));
    }
    public function attach_user_store(Request $request)
    {
      // $permission = "Assign a Role to User";
      // if(auth()->user()->can($permission) == false)
      //     {
      //       abort(403);
      //     }

                $user = User::find($request->user_id);
                $user->syncRoles($request->roles_id);
                // return $request;
                return redirect()->route('users');
    }

}
