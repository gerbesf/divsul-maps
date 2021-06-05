<?php

namespace App\Http\Livewire\Traits;

use App\Models\LevelsIndex;
use App\Models\ServerHistory;
use Carbon\Carbon;

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
    protected function bindData(){
        $this->findRequestInputs();
        $this->populateHistory();
        $this->populateOptions();
        $this->makeAvaliableMaps();
    }

    /**
     * Populate History -  Rotation of maps
     */
    protected function populateHistory(){

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
        if($this->players && $this->layout){
            $LevelsIndex = LevelsIndex::query();
            $LevelsIndex->where('players',$this->players);
            $LevelsIndex->where('game_mode', $this->layout  );
            $this->reality_maps = $LevelsIndex->get();
        }else{
            $this->reality_maps  = [];
        }

    }

    /**
     * Make Avaliable Maps
     * Combine history and maps to make avaliable maps
     */
    public function makeAvaliableMaps(){

        $this->avaliable_maps = [];
        $result = [];
        foreach($this->reality_maps as $reality_map)
        {
            $found = false;
            foreach($this->server_maps as $server_map)
            {
                if( $reality_map['size'] == $server_map['map_size']
                    && $reality_map['map_key']==$server_map['map_key']
                    && $reality_map['map_mode']==$server_map['game_mode']
                ){
                    $found = true;
                }
            }
            $reality_map['unavaliable'] = $found;
            $result[$reality_map['id']] = $reality_map;
        }
        foreach($result as $item)
        {
            if(!$item['unavaliable']){
                $this->avaliable_maps[] = $item;
                $this->zmaps[ $item['map_key'] ]=$item['map_key'];
            }
        }

        $this->reality_maps = $result;

        if(count( $this->zmaps)>=3){
            if(count($this->avaliable_maps) >=5){
                $this->emit('disableVotemap',false);
            }else{
                $this->emit('disableVotemap',true);
            }
        }

    }

}
