<div>


    <div>


        <div>

            @if(!$entity && $layout && $players)

                <button class="btn btn-primary btn-block" wire:click="unlockVotemap(true)" @if($locked) disabled @endif >Start a new vote</button>

            @else

                <button class="btn btn-primary btn-block" @if($locked) disabled @endif >Start a new vote</button>

            @endif
        </div>

        @if (session()->has('message'))
            <div class="alert alert-warning rounded-lg ">
                {!! session('message') !!}
            </div>
        @endif
    </div>
</div>
