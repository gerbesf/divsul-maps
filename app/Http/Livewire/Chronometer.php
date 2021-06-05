<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\VoteEntity;
use App\Models\Votes;
use Livewire\Component;

class Chronometer extends Component
{

    use VoteEntity;

    public function mount(){
        $this->loadVoteEntity();
    }


    public function checkValid(){
        #dd($this->entity->expires_at );
        if(  \Carbon\Carbon::parse( $this->entity->expires_at )->isPast() ==true){
         #   dd('redirect crono'.$this->entity->expires_at);
            return redirect('/');
        }
    }

    public function render()
    {
        return view('livewire.chronometer');
    }
}
