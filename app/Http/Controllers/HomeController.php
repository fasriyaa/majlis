<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function users()
    {
      $permission = "View Users";
      $err_url = "layouts.exceptions.403";
      if(auth()->user()->can($permission) == true)
      {
            $users = User::with('roles')->get();

            return view('auth.users', compact('users'));
            }else {
              return view($err_url);
      }

    }
}
