<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Traits\VoteEntity;
use App\Http\Livewire\Traits\VotemapEngine;
use App\Http\Livewire\Traits\VotemapFilter;
use App\Models\Levels;
use App\Models\LevelsIndex;
use App\Models\ServerHistory;
use Carbon\Carbon;
use Livewire\Component;

class MapView extends Component
{

    use VotemapFilter;
    use VotemapEngine;
    use VoteEntity;

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


    // Listeners
    public $listeners = [
        'filter_players',
        'filter_layout',
    ];

    // Constructor
    public function mount(){
        $this->bindData();
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

    public function render()
    {
        return view('livewire.map-view');
    }
}
