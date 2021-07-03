<?php

namespace App\Http\Livewire;

use App\Models\Clans;
use App\Models\Offline;
use App\Models\Online;
use Livewire\Component;

class PlayersOnline extends Component
{

    public $groupTeams = true;
    public $highOnly = false;
    public $selectedClan = null;

    public $clans = [];
    public $players = [];

    #public $results = [];

    public function mount(){
    #    $query  = Online::get();
       # $this->clansOptions( $query );
    }#

    public function clansOptions($query){
     /*   foreach($query as $item){
            if($item->tag){
                $this->clans[$item->tag] =$item->tag;
            }
            $this->players[] = $item->nick;
        }*/
    }

    public function makeView(){
        $query  = Online::get();
        $results = [];
        if($this->groupTeams==false){
            foreach($query as $item){
                $results[] = $item->toArray();
            }
        }else{
            foreach($query as $item){
                $results[$item->team][] = $item->toArray();
            }
        }
        return $results;
    }

    public function render()
    {
        return view('livewire.players-online',[
            'offline'=>Offline::get(),
            'results'=>Online::orderBy('score','desc')->get()
        ]);
    }
}
