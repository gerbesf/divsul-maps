<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AdminsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function management(){

        if(Auth::user()->level!="M")
            return redirect('/');

        return view('admins');
    }
}
