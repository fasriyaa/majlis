<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
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
      $permissions = Permission::get();
      // $permissions = Permission::with('role')->get();
      // return $permissions;
      return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $permissions = Permission::create($request->all());
      return redirect()->route('permissions.index');
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
    public function edit(Permissions $permissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permissions  $permissions
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permissions $permissions)
    {
        //
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
      $role = Role::FindById($role_id);
      $permission = Permission::FindById($permission_id);
      $role->givePermissionTo($permission);


      return redirect()->route('permissions.index');

      // var_dump($permission);
    }

    public function assign_role($user_id,$role_id)
    {
      $role = Role::FindById($role_id);
      $user = User::FindOrFail($user_id);
      $user->assignRole($role->name);


      return redirect()->route('permissions.index');



      // var_dump($data);
    }
}
