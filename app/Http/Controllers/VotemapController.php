<?php

namespace App\Http\Controllers;

use App\Models\Votes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VotemapController extends Controller
{

    public $entity;

    public function votemap( Request $request ){

        try {


            // force fail to redirect
            $this->entity = Votes::where('id',$request->get('vId'))->where('user_id',Auth::user()->id)->firstOrFail();

            // force redirect if expired
            if(  \Carbon\Carbon::parse( $this->entity->expires_at )->isPast() ==true){
                return redirect('/');
            }

            return view('votemap',[
                'layout'=>$this->entity->layout,
                'players'=>$this->entity->players,
                'votemap'=>$this->entity->votemap,
            ]);

        }catch ( \Exception $exception ){
            return redirect('/?error');
         #   return redirect('/?error='.$exception->getMessage());
        }
    }

}
