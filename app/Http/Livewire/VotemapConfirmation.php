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

        // Active vote
        $this->loadVoteEntity();

        // Binds
        $this->bindData();

        // Confirmation Options
        $this->options = $this->entity->votemap;

       # dd($this->entity->votemap);

    }

    public function confirmVote( $id ){

        // Confirmed Level
        $Level = LevelsIndex::where('id',$id)->firstOrFail();

        // Discord Message
        dispatch( new DiscordMessage( 'success', Auth::user()->nickname, 'confirmou o votemap',[
            'winner'=>$Level
        ]));

        // Close Vote
        Votes::where('id',$this->entity->id)->update([
            'winner'=>$Level,
            'status'=>'complete'
        ]);

        session()->flash('message', 'Success!');


        return redirect('/');
    }

    public function render()
    {
        return view('livewire.votemap-confirmation');
    }
}
