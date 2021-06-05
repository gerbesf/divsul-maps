<div>

    <div class="py-5 ">
        <div class="max-w-4xl m-auto mb-5 mb-20">
            <div class="grid grid-cols-3 mb-5 gap-4">

                @foreach($options as $option)
                    <div class="p-4 border border-base-200 bg-base-300 text-neutral-content">
                        <img class="" src="https://www.realitymod.com/mapgallery/images/maps/{{ $option['map']['Image'] }}/mapoverview_gpm_{{ $option['game_mode'] }}_{{ $option['size'] }}.jpg">

                        <div class="p-5">

                            <div class="font-bold">{{ $option['map']['Name'] }}</div>
                            {{-- <div>{{ __('app.'.$option['game_mode']) }}</div>--}}
                            <div>{{ __('app.sized_'.$option['size']) }}</div>

                        </div>
                        <button class="btn btn-primary btn-block mb-5" wire:click="confirmVote({{ $option['id'] }})">{{ $option['map']['Name'] }}</button>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
