<?php

namespace App\Http\Middleware;

use App\Models\Server;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Setup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if( Server::count()==0) {
            if(Auth::user() && Auth::user()->level && \Route::currentRouteName()!='setup') {
                return redirect('/setup');
            }
            return redirect('/offline');
        }

        return $next($request);
    }
}
