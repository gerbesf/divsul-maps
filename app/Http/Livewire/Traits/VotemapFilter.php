<?php

namespace App\Http\Livewire\Traits;

trait VotemapFilter {

    // Query for player quantity
    public $players = '';

    // Query for layout map
    public $layout = '';
    public $layouts = '';

    public function findRequestInputs(){

        if(request()->has('layout')){
            $this->layout = request()->get('layout');
        }
        if(request()->has('players')){
            $this->players = request()->get('players');
        }

        if( isset($this->entity->layout)){
            $this->layout = $this->entity->layout;
        }
        if( isset($this->entity->players)){
            $this->players = $this->entity->players;
        }

    }


}
