<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\User;

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
        $users = User::with('roles')->get();
        // $users_permission = User::with('permissions')->get();


        // $roles = $user->getRoleNames(); // Returns a collection of roles name assinged to user

        // return $users_permission;
        return view('auth.users', compact('users'));
    }
}
