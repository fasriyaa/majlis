<?php

namespace App\Http\Controllers\Modules;

use App\Http\Controllers\Controller;

use App\models\modules\MainModules;
use Illuminate\Http\Request;

use App\Requests\Modules\StoreMainModulesRequest;

use Auth;
class MainModulesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // $permission = "View Modules";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
        // Getting the full list of main modules list
        $main_modules = MainModules::get();
        return view('modules.index', compact('main_modules'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
      // $permission = "Create Modules";
      // if(auth()->user()->can($permission) == true)
      // {
      //   abort(403);
      // }
          return view('modules.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMainModulesRequest $request)
    {
      // $permission = "Create Modules";
      // if(auth()->user()->can($permission) == false)
      // {
      //   abort(403);
      // }
        $main_modules = MainModules::create($request->all() + ['status' => 1]);
        return redirect()->route('main_modules.index');
        // return route('modules.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MainModules  $mainModules
     * @return \Illuminate\Http\Response
     */
    public function show(MainModules $mainModules)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MainModules  $mainModules
     * @return \Illuminate\Http\Response
     */
    public function edit(MainModules $mainModules)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MainModules  $mainModules
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MainModules $mainModules)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MainModules  $mainModules
     * @return \Illuminate\Http\Response
     */
    public function destroy(MainModules $mainModules)
    {
        //
    }
}
