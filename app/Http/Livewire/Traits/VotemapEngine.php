<?php

namespace App\Http\Livewire\Traits;

use App\Jobs\DiscordMessage;
use App\Models\LevelsIndex;
use App\Models\ServerHistory;
use App\Models\Votes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

trait VotemapEngine {

    /**
     * Server Maps
     * Historic of maps
     *
     * @var array
     */
    public $server_maps = [];

    /**
     * Reality Maps
     * All Maps
     *
     * @var array
     */
    public $reality_maps = [];

    /**
     * Avaliable maps
     * After combination
     *
     * @var array
     */
    public $avaliable_maps = [];


    /**
     * @var array
     * Maps to Internal Count
     *
     */
    public $zmaps = [];

    /**
     * Bind All Data
     */
    public function bindData(){
        $this->findRequestInputs();
        $this->populateHistory();
        $this->populateOptions();
        $this->makeAvaliableMaps();
      #  dd($this->reality_maps);
    }

    /**
     * Populate History -  Rotation of maps
     */
    public function populateHistory(){

        // Limits to log
        $days_limit = env('DIV_MAXD') ?: 2;
        $date_today = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $date_limit = Carbon::now()->subDays( $days_limit + 1 )->endOfDay()->format('Y-m-d H:i:s');

        // Query
        if($this->layout){
            $ServerHistory = ServerHistory::query();
            $ServerHistory = ServerHistory::where('valid',true);
            $ServerHistory = $ServerHistory->whereBetween('timestamp',[$date_limit,$date_today])->orderBy('id','desc');
            $ServerHistory = $ServerHistory->where('map_mode',$this->layout);
            $this->server_maps = $ServerHistory->get();
        }

    }

    /**
     * Populate Options
     */
    public function populateOptions(){

        // Avaliable Options Query
      #
        #if($this->players && $this->layout){
            $LevelsIndex = LevelsIndex::query();
            $LevelsIndex->where('players',$this->players);
            $LevelsIndex->where('game_mode', $this->layout  );
            $this->reality_maps = $LevelsIndex->get();
           # dd($LevelsIndex->get(),'pl');
           # dd($LevelsIndex->get(),$this->players,$this->layout);
          #  dd($this->reality_maps);
            if(!$this->reality_maps){
                dd('xxxxxxxxxxx',[$this->players , $this->layout]);
            }
        #}else{
        #    $this->reality_maps  = [];
       # }

    }

    /**
     * Make Avaliable Maps
     * Combine history and maps to make avaliable maps
     */
    public function makeAvaliableMaps(){

        $this->zmaps = [];
        $this->avaliable_maps = [];
       # $this->reality_maps = [];
        $this->populateOptions();
        $result = [];
        foreach($this->reality_maps as $reality_map)
        {
            $found = false;
         #   dd($this->server_maps,$this->layout);
            foreach($this->server_maps as $server_map)
            {
               # dd($reality_map,$this->server_maps);
             #   dd('x',$reality_map['map_mode'],$server_map['game_mode']);
              #  $reality_map['size'] == $server_map['map_size'] &&
                if( $reality_map['map_key']==$server_map['map_key']
                    && $reality_map['game_mode']==$server_map['map_mode']
                ){
                    $found = true;
                }

               # dd($reality_map['map_mode'],$reality_map,$server_map);

            }
            $reality_map['unavaliable'] = $found;
            $result[$reality_map['id']] = $reality_map;

            if(!$found){
                $this->avaliable_maps [] = $reality_map;
            }


            if(!$found && isset($reality_map['map_key']))
                $this->zmaps[ $reality_map['map_key'] ] = $reality_map['map_key'];

        }

      #  $this->avaliable_maps = $result;
/*        $this->avaliable_maps = collect( $result )->filter(function ($obj){
            if(!isset($obj['unavaliable'])) return $obj;
        });*/

        if(count( $this->zmaps)>=3){
            if(count($this->zmaps) >=3){
                $this->emit('disableVotemap',false);
            }else{
                $this->emit('disableVotemap',true);
            }
        }else{
            $this->emit('disableVotemap',false);
        }

    }




}
