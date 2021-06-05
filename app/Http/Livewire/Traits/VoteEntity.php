<?php

namespace App\Http\Livewire\Traits;

use App\Models\LevelsIndex;
use App\Models\ServerHistory;
use App\Models\Votes;
use Carbon\Carbon;

trait VoteEntity
{

    public $entity;

    public function loadVoteEntity(){

        $valid = Votes::where('id',request()->get('vId'))->where('status','votting')->count();
        if(!request()->has('vId') or !$valid) return redirect('/');
        $this->entity = Votes::where('id',request()->get('vId'))->where('status','votting')->first();

        #dd($this->entity);
    }

    public function getRandom( $limit ){
        $numbers = array();
        while ( count($numbers) <= 2 ) {
            $x = mt_rand(0,$limit);
            if ( !in_array($x,$numbers) ) {
                $numbers[] = $x;
            }
        }
        return $numbers;
    }

}
