<?php

namespace App\Http\Livewire\Admin;

use App\Models\LevelsIndex;
use App\Models\LevelsPlayers;
use Livewire\Component;

class MapCheckbox extends Component
{
    public  $map_key,
        $size,
        $game_mode,
        $layout,
        $player;

    public $iai;

    public function mount( $map_key , $game_mode, $size, array $player )
    {
        $this->map_key = $map_key;
        $this->size = $size;
        $this->game_mode = $game_mode;
        $this->player = $player;

        if( LevelsIndex::where('map_key',$this->map_key)->where('size',$this->size)->where('game_mode',$this->game_mode)->where('players',$this->player['code'])->count() == 1){
            $this->iai=true;
        }

    }


    public function updatedIai( $value ){

        if($value){
            LevelsIndex::firstOrCreate([
                'map_key' => $this->map_key,
                'size' => $this->size,
                'game_mode' => $this->game_mode,
                'players' => $this->player['code'],
            ]);
        }else{
            LevelsIndex::where('map_key',$this->map_key)->where('size',$this->size)->where('game_mode',$this->game_mode)->where('players',$this->player['code'])->delete();
        }
    }

    public function render()
    {
        return view('livewire.admin.map-checkbox');
    }
}
