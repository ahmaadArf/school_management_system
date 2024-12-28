<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\MyParent;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        return view('dashboard');
    }
    public function selection(){
        return view('auth.selection');
    }
    public function loginForm($type){
        return view('auth.login',compact('type'));
    }

}
