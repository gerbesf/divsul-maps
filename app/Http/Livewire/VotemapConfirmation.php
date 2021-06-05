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

class VotemapConfirmation extends Component
{

    use VotemapFilter;
    use VoteEntity;
    use VotemapEngine;

    public  $options = [];

    // Constructor
    public function mount()
    {

        $this->loadVoteEntity();

        $this->bindData();

        #dd($this->entity->votemap);
        $this->options = $this->entity->votemap;

    }

    public function confirmVote( $id ){
        $Level = LevelsIndex::where('id',$id)->first();

        dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'confirmou o votemap',[
            'winner'=>$Level
        ]));

        Votes::where('id',$this->entity->id)->update([
            'winner'=>$Level,
            'status'=>'complete'
        ]);

        return redirect('/');
    }

    public function render()
    {
        return view('livewire.votemap-confirmation');
    }
}
