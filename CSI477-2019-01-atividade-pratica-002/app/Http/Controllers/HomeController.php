<?php

namespace App\Http\Controllers;
use App\Procedure;
use App\Test;
use Illuminate\Support\Facades\Gate;

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
        $tests = Test::all();
        //usuario do tipo paciente
        if(Gate::allows('manage-my-tests')){
            return view('dashboard_pacient',['procedures'=>$procedures]);
        }

        //usuario do tipo admin ou operador
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
