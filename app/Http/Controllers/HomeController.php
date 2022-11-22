<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class HomeController extends Controller
{
    
    public function index(){
        if (!empty(Auth::user()->name)){
            return view('home');
        }else{
            return redirect(URL::route('login'));
        }        
    }
}
