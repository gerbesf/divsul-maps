<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

use Storage;

class IndexController extends Controller
{
    public function welcome(){
        return view('welcome');
    }
}
