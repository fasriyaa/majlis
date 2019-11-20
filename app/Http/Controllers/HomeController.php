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
        $users = User::get();
        // return $users;
        return view('auth.users', compact('users'));
    }
}
