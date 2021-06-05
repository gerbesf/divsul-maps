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
    public $players = [];
    public $layout = [];
    public $sorteado = [];
    public $history = [];
    public $votemap_text;

    use VoteEntity;
    use VotemapFilter;
    use VotemapEngine;

    public function mount()
    {

        $this->bindData();

        $this->loadVoteEntity();

        $this->bindData();


        if( Cache::has('votes_'.$this->entity->id) ){
            $c = ( Cache::get('votes_'.$this->entity->id));
            $this->history = $c;
        }

        if($this->history){

            $votemap_text = '';
            foreach($this->history[ count($this->history)-1 ] as $idD=>$history){
                $map = LevelsIndex::where('id', (int) $idD)->first();
                $this->sorteado[] = $map;
                if( isset($map['map_key'])){
                    $votemap_text .= ' '.substr($map['map_key'],0,9).' ';
                }else{
                    $votemap_text .= '  -- ?? -- ';
                }

            }
            $this->votemap_text = $votemap_text;
        }


      #  $this->findRequestInputs();
       # $this->populateHistory();
       # $this->populateOptions();
       # $this->makeAvaliableMaps();
        $this->bindData();

        if(!$this->history)
            $this->getUnique();
      #  dd($this->avaliable_maps);
    }

    public function loadVoteEntity(){
        $valid = Votes::where('id',request()->get('vId'))->where('status','votting')->count();
        if(!request()->has('vId') or !$valid) return redirect('/');
        $this->entity = Votes::where('id',request()->get('vId'))->where('status','votting')->first();
    }

    public function runSweepstakes(){
     #   $this->loadVoteEntity();
        $this->loadVoteEntity();
          $this->findRequestInputs();
         $this->populateHistory();
         $this->populateOptions();
         $this->makeAvaliableMaps();
        $this->getUnique();
    }

    public function getUnique(){

        $this->sorteado = [];
        $maps = [];
        $votemap_text ='';

       /* $avaliable_maps = collect( $this->avaliable_maps )->filter(function ($obj){
            if(isset($obj['unavaliable']) && $obj['unavaliable'] == false){
                return $obj;
            }
        });*/
       # dd($this->avaliable_maps,$avaliable_maps);
        if(count($this->avaliable_maps)){

            $sorteado = $this->getRandom( count($this->avaliable_maps)-1 );

            $toSort = array_values($this->avaliable_maps);

            foreach($sorteado as $item){
                if( isset($maps[$toSort[ $item ]->map->Key])) return $this->getUnique();
                $maps[$toSort[ $item ]->map->Key] = $toSort[ $item ]->map->Key;
                $this->sorteado[] = $toSort[ $item ];
                $votemap_text .= ' '.substr($toSort[ $item ]['map_key'],0,9).' ';
                $votemap_history[$toSort[ $item ]->id] = $toSort[ $item ]->map->Name;
                #$votemap_history[$toSort[ $item ]->id] = $toSort[ $item ]->map->Name.' - '.__('app.size_'.$toSort[ $item ]['size']);
            }

            $this->history = array_merge($this->history,[$votemap_history]);

            $this->votemap_text = $votemap_text;

            Cache::put('votes_'.$this->entity->id,($this->history));
        }

    }


    public function confirmVote(){

        $history = $this->history;
        unset($history[ count($history)-1]); // remove actual vote from list

        $payload = [
            'votemap' => $this->sorteado,
            'rotations_history' => $history,
            'expires_at' => Carbon::now()->addMinutes(env('DIV_MAXV') ?: 3),
        ];

        Votes::where('id',$this->entity->id)->update($payload);

        // Discord Message
        dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'Está votando ',  [
            'votemap'=>$this->sorteado,
            'history'=>$history
        ]));

        return redirect('/votemap?vId='.$this->entity->id);
    }


    /*
        public $server_maps = [];
        public $reality_maps = [];
        public $avaliable_maps = [];
        public $zmaps = [];


        use VotemapFilter;
        use VotemapEngine;
        use VoteEntity;

        public $layout;
        public $players;

        public $selectedOption = 'latest';


        // Listeners
        public $listeners = [
            'filter_players',
            'filter_layout',
        ];

        // Constructor
        public function mount(){

            $this->bindData();

            $this->loadVoteEntity();

            $this->bindData();

            if( Cache::has('votes_'.$this->entity->id) ){
                $c = ( Cache::get('votes_'.$this->entity->id));
                $this->history = $c;
            }

            if($this->history){

              #  dd($this->history);
                $votemap_text = '';
              #  dd($this->history[ count($this->history)-1 ]);
                foreach($this->history[ count($this->history)-1 ] as $idD=>$history){
                    $map = LevelsIndex::where('id', (int) $idD)->first();
                    print_r($map);
                    echo $idD.'<hr>';
                    $this->sorteado[] = $map;
                  #  dd($idD,$history,$map);
                    if( isset($map['map_key'])){
                        $votemap_text .= ' '.substr($map['map_key'],0,9).' ';
                    }else{
                        $votemap_text .= '  -- ?? -- ';
                    }

                }
                $this->votemap_text = $votemap_text;
            }
       #     dd($this->sorteado);

            if(!$this->history)
                $this->runSweepstakes();
        }

        public function runSweepstakes(){
            $this->loadVoteEntity();
            $this->bindData();
            $this->getUnique();
        }

        public function getUnique(){

           # dd($this->avaliable_maps);
            $this->sorteado = [];
            $maps = [];
            $votemap_text ='';

            if(count($this->avaliable_maps)){

                #dd($this->avaliable_maps, count($this->avaliable_maps)-1 );
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
*/

    public function render()
    {
        return view('livewire.votemap-rotation');
    }
}
