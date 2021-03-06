<?php

namespace App\Http\Livewire\Traits;

trait VotemapFilter {

    public function findRequestInputs(){

        // -- on request
        if(request()->has('layout')){
            $this->layout = request()->get('layout');
        }
        if(request()->has('players')){
            $this->players = request()->get('players');
        }

        // -- on entity
        if( isset($this->entity->layout)){
            $this->layout = $this->entity->layout;
        }
        if( isset($this->entity->players)){
            $this->players = $this->entity->players;
        }

    }



}
