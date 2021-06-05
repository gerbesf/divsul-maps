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

class MapView extends Component
{

    // Query for player quantity
    public $players = '';

    // Query for layout map
    public $layout = '';

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


    public function unlockVotemap( $doAction = true ){

        $active = Votes::where('status','votting')->count();

        if($active==0 && $doAction==true){

            dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'Iniciou um votemap '.__('app.'.$this->layout). ' - '.str_replace('_',' até ',$this->players)));

            $new_vote = [
                'user_id'=>Auth::user()->id,
                'status'=>'votting',
                'expires_at' => Carbon::now()->addMinutes(env('DIV_MAXV') ?: 3),
                'layout'=>$this->layout,
                'players'=>$this->players
            ];
            $this->entity = Votes::create($new_vote);

        }else{

            $active = Votes::where('status','votting')->first();

            // If expired, delete and redirect
            if(isset($active->user_id) && Carbon::parse($active->expires_at)->isPast()==true){
                Votes::where('id',$active->id)->update([
                    'status'=>'expired'
                ]);

                dispatch( new DiscordMessage( 'error', Auth::user()->nickname, 'Expirou '));
                return redirect('/');
            }

            // If is another user
            if(isset($active->user_id) && $active->user_id != Auth::user()->id){
                session()->flash('message', '<span><u class="mr-1">'.$active->user->nickname.'</u> Votting now! <b class="pl-1 pr-2">Limit: '. str_replace('from now','', Carbon::parse($active->expires_at)->diffForHumans() ).' </b></span>');
            }else{
                $this->entity = $active;
            }
        }

        if($this->entity){
            return redirect('/votemap?vId='.$this->entity->id);
        }

    }

    public function render()
    {
        $this->bindData();
        return view('livewire.map-view');
    }


    // Watch Players Change
    public function filter_players( $value ){
        $this->players = $value;
    }

    // Watch Layout Change
    public function filter_layout( $value ){
        $this->layout = $value;
    }

}
