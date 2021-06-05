<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\VoteEntity;
use App\Http\Livewire\Traits\VotemapEngine;
use App\Http\Livewire\Traits\VotemapFilter;
use App\Jobs\DiscordMessage;
use App\Models\Levels;
use App\Models\LevelsIndex;
use App\Models\ServerHistory;
use App\Models\Votes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Cache;

class VotemapRotation extends Component
{

    use VotemapFilter;
    use VotemapEngine;
    use VoteEntity;

    public $selectedOption = 'latest';
    public $sorteado = [];
    public $history = [];

    public $votemap_text;

    // Listeners
    public $listeners = [
        'filter_players',
        'filter_layout',
    ];

    // Constructor
    public function mount(){

        $this->loadVoteEntity();

        $this->bindData();

        if( Cache::has('votes_'.$this->entity->id) ){
            $c = ( Cache::get('votes_'.$this->entity->id));
            $this->history = $c;
        }

        if($this->history){
            $votemap_text = '';
            foreach($this->history[ count($this->history)-1 ] as $idD=>$history){
                $map = LevelsIndex::where('id',$idD)->first();
                $this->sorteado[] = $map;
                $votemap_text .= ' '.substr($map['map_key'],0,9).' ';

            }
            $this->votemap_text = $votemap_text;
        }

        if(!$this->history)
            $this->runSweepstakes();
    }

    public function runSweepstakes(){
        $this->bindData();
        $this->getUnique();
    }

    public function getUnique(){

        $this->sorteado = [];
        $maps = [];
        $votemap_text ='';

        $sorteado = $this->getRandom( count($this->avaliable_maps)-1 );

        foreach($sorteado as $item){
            if( isset($maps[$this->avaliable_maps[ $item ]->map->Key])) return $this->getUnique();
            $maps[$this->avaliable_maps[ $item ]->map->Key] = $this->avaliable_maps[ $item ]->map->Key;
            $this->sorteado[] = $this->avaliable_maps[ $item ];
            $votemap_text .= ' '.substr($this->avaliable_maps[ $item ]['map_key'],0,9).' ';
            $votemap_history[$this->avaliable_maps[ $item ]->id] = $this->avaliable_maps[ $item ]->map->Name.' - '.__('app.size_'.$this->avaliable_maps[ $item ]['size']);
        }

        $this->history = array_merge($this->history,[$votemap_history]);

        $this->votemap_text = $votemap_text;

        Cache::put('votes_'.$this->entity->id,($this->history));

    }

    // Watch Players Change
    public function filter_players( $value ){
        $this->players = $value;
        $this->bindData();
    }

    // Watch Layout Change
    public function filter_layout( $value ){
        $this->layout = $value;
        $this->bindData();
    }

    public function confirmVote(){

        $history = $this->history;
        unset($history[ count($history)-1]);
        $payload = [
            'votemap' => $this->sorteado,
            'rotations_history' => $history,
            'expires_at' => Carbon::now()->addMinutes(env('DIV_MAXV') ?: 3),
        ];

        dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'Está votando ',  [
            'votemap'=>$this->sorteado,
            'history'=>$history
        ]));
       # dd('iun');


        Votes::where('id',$this->entity->id)->update($payload);
        return redirect('/votemap?vId='.$this->entity->id);
    }

    public function render()
    {
        return view('livewire.votemap-rotation');
    }
}
