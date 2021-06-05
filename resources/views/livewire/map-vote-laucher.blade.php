<div>

    <div class="wire:loading">--------</div>
    @if(!$entity)

        <button class="btn btn-primary btn-block" wire:click="unlockVotemap" @if($locked) disabled @endif >Start a new vote</button>

    @else

        <button class="btn btn-primary btn-block" @if($locked) disabled @endif >Start a new vote</button>

    @endif

        @if (session()->has('message'))
            <div class="alert alert-warning rounded-lg ">
                {!! session('message') !!}
            </div>
        @endif
</div>
