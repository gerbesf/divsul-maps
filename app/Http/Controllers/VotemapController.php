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

            $this->entity = Votes::where('id',$request->get('vId'))->where('user_id',Auth::user()->id)->firstOrFail();

            if(  \Carbon\Carbon::parse( $this->entity->expires_at )->isPast() ==true){
                #dd('redir by time', \Carbon\Carbon::parse( $this->entity->expires_at )->isPast() , \Carbon\Carbon::parse( $this->entity->expires_at )->format('d/m/Y H:i:s'));
                return redirect('/');
            }

            return view('votemap',[
                'layout'=>$this->entity->layout,
                'players'=>$this->entity->players,
                'votemap'=>$this->entity->votemap,
            ]);

        }catch ( \Exception $exception ){
            return redirect('/?error=');
        }
    }

    public function confirmation( Request $request ){

    /*    try {

            $this->entity = Votes::where('id',$request->get('vId'))->where('user_id',Auth::user()->id)->firstOrFail();
            if(  \Carbon\Carbon::parse( $this->entity->expires_at )->isPast() ==true){
                return redirect('/');
            }

            return view('votemap',[
                'layout'=>$this->entity->layout,
                'players'=>$this->entity->players,
                'votemap'=>$this->entity->votemap,
            ]);

        }catch ( \Exception $exception ){
            return redirect('/?error=');
        }*/
    }
}
