<?php

namespace App\Http\Controllers;
use App\Procedure;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['welcome']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $procedures = Procedure::all();
        return view('dashboard',['procedures'=>$procedures]);
    }

    /**
     * Show the application public page
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        $procedures = Procedure::all();
        return view('welcome',['procedures'=>$procedures]);
    }    
}
