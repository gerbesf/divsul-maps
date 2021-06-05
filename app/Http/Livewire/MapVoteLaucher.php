<?php

namespace App\Http\Livewire;

use App\Jobs\DiscordMessage;
use App\Models\ServerHistory;
use App\Models\Votes;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MapVoteLaucher extends Component
{

    // Entity of Vote
    public $entity = null;

    // Is locked
    public $locked = true;

    // Selected Layout
    public $layout = null;

    // Selected Player Size
    public $players = null;

    public $listeners = [
        'filter_players',
        'filter_layout',
    ];

    // Watch Players Change
    public function filter_players( $value ){
        $this->players = $value;
    }

    // Watch Layout Change
    public function filter_layout( $value ){
        $this->layout = $value;
    }


    public function mount( $locked = true, $layout, $players){

        $this->locked = $locked;

        $this->layout = $layout;
        $this->players = $players;

        $active = Votes::where('status','votting')->first();
        if(isset(Auth::user()->id) && isset($active->user_id) && $active->user_id != Auth::user()->id){
            session()->flash('message', 'Votemap is locked for another admin');
        }else{
            if($active){
                $this->layout = $active->layout;
                $this->entity = $active;
            }
        }

        $this->unlockVotemap(false);
    }

    public function unlockVotemap( $doAction = true ){

        $active = Votes::where('status','votting')->count();

        if($active==0 && $doAction==true){

            $new_vote = [
                'user_id'=>Auth::user()->id,
                'status'=>'votting',
                'expires_at' => Carbon::now()->addMinutes(env('DIV_MAXV') ?: 3),
                'layout'=>$this->layout,
                'players'=>$this->players
            ];
            dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'Iniciou um votemap '.__('app.'.$this->layout). ' - '.str_replace('_',' até ',$this->players)));

            $this->entity = Votes::create($new_vote);

        }else{

            $active = Votes::where('status','votting')->first();

            // If expired, delete and redirect
            if(isset($active->user_id) && Carbon::parse($active->expires_at)->isPast()==true){
                Votes::where('id',$active->id)->update([
                    'status'=>'expired'
                ]);

                $VoteS = Votes::where('id',$active->id)->first();
                dispatch( new DiscordMessage( 'error', $VoteS->user->nickname, 'Teve o seu vote expirado'));

                return redirect('/');
            }

            // If is another user
            if( isset(Auth::user()->id) && isset($active->user_id) && $active->user_id != Auth::user()->id){
                session()->flash('message', '<span><u class="mr-1">'.$active->user->nickname.'</u> Votting now! <b class="pl-1 pr-2">Limit: '. str_replace('from now','', Carbon::parse($active->expires_at)->diffForHumans() ).' </b></span>');
            }else{
                $this->entity = $active;
            }
            #   dd($this->entity);
        }

        if($this->entity){
            return redirect('/votemap?vId='.$this->entity->id);
        }
    }

    public function render()
    {
        return view('livewire.map-vote-laucher');
    }
}
