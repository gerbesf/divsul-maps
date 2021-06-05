<?php

namespace App\Http\Controllers;

use App\Models\Filters;
use App\Models\Levels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MapsController extends Controller
{

    public $filterss = [];

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function management(){

        if(Auth::user()->level!="M")
            return redirect('/');

        $levels = Levels::get();
        $filters = Filters::whereIn('name',['Players'])->get(); // ->groupBy('name')
        $filters = collect($filters)->map(function ($obj){
            return [
                $obj->name=>$obj['settings']
            ];
        })->toArray();
        $filters = collect($filters)->map(function ($obj){
            $this->filters[array_key_first($obj)] = $obj[array_key_first($obj)];
        })->toArray();

        return view('maps',[
            'levels'=>$levels,
            'filters'=>$this->filters
        ]);
    }
}
