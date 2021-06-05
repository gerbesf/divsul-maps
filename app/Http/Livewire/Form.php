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

    use VotemapFilter;

    // Array with filters
    public $filters = [];

    // Query string
    public $queryString = ['players','layout'];

    // Construct
    public function mount(){

        // avaliable filters
        $this->filters = Filters::orderBy('name','asc')->get()->toArray();

        // Input Players based on server
        $this->autoSelectPlayers();

        // Input Layout based on url
        $this->autoSelectLayout();

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

    /**
     * Automatic select Input Players
     */
    protected function autoSelectPlayers(){

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
        }
    }

    protected function autoSelectLayout(){
        if(request()->has('layout')){
            $this->layout = request()->get('layout');
            $this->emit('filter_layout',$this->layout);
        }
    }

    public function render()
    {
        $this->emit('filter_players',$this->players);
        return view('livewire.form');
    }
}
