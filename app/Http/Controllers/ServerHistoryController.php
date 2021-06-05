<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ServerHistoryController extends Controller
{
    public function history(){

        // Limits to log
        $days_limit = env('DIV_MAXD') ?: 2;

        $date_today = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $date_limit = Carbon::now()->subDays( $days_limit + 1 )->endOfDay()->format('Y-m-d H:i:s');

        $collection = \App\Models\ServerHistory::whereBetween('timestamp',[$date_limit,$date_today])->orderBy('id','desc')->paginate(200);
        return view('history',[
            'days_limit'=>$days_limit,
            'collection'=>$collection
        ]);
    }
}
