<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\VotemapFilter;
use App\Models\Filters;
use App\Models\Server;
use App\Models\ServerHistory;
use Livewire\Component;

/**
 * Class Form
 * Form of votemap
 * @package App\Http\Livewire
 */
class Form extends Component
{

    // Query for player quantity
    public $players = '';

    // Query for layout map
    public $layout = '';

    use VotemapFilter;

    // Array with filters
    public $filters = [];

    // Query string
    public $queryString = ['players','layout'];

    // Construct
    public function mount(){

        // avaliable filters
        $this->filters = Filters::orderBy('name','asc')->get()->toArray();
/*
        // Input Players based on server
        $lastEntity = ServerHistory::orderBy('id','desc')->first();
        if(isset($lastEntity->players)){
            if($lastEntity->players<=30){
                $this->players = '0_30';
            }
            if($lastEntity->players>=31 && $lastEntity->players<=40){
                $this->players = '31_40';
            }
            if($lastEntity->players>=41 && $lastEntity->players<=60){
                $this->players = '41_60';
            }
            if($lastEntity->players>=61 && $lastEntity->players<=80){
                $this->players = '61_80';
            }
            if($lastEntity->players>=81 && $lastEntity->players<=100){
                $this->players = '81_100';
            }
        }*/

        // Input Layout based on url
        if(request()->has('layout')){
            $this->layout = request()->get('layout');
            $this->emit('filter_layout',$this->layout);
        }

        // Input Layout based on url
        if(request()->has('players')){
            $this->players = request()->get('players');
            $this->emit('filter_players',$this->players);
        }

    }

    // Trigger updated
    public function updated($key,$value){
        if($key=='players'){
            $this->emit('filter_players',$value);
            $this->players = $value;
        }
        if($key=='layout'){
            $this->emit('filter_layout',$value);
            $this->layout = $value;
        }
    }


    public function render()
    {
        #$this->emit('filter_players',$this->players);
        #$this->emit('filter_layout',$this->layout);
        return view('livewire.form');
    }
}
