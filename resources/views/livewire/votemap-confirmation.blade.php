<div>

    <div class="py-5 ">
        <div class="max-w-5xl m-auto mb-5 mb-20">
            <div class="grid grid-cols-3 mb-5 gap-4">

                @foreach($options as $option)
                    <div class="p-4 borxder border-base-200 bxg-base-300 text-neutral-content">
                        <img class="" src="https://www.realitymod.com/mapgallery/images/maps/{{ $option['map']['Image'] }}/mapoverview_gpm_{{ $option['game_mode'] }}_{{ $option['size'] }}.jpg">

                        <div class="p-5">

                            <div class="font-bold uppercase text-xl">{{ $option['map']['Name'] }}</div>

                            <div style="min-height: 100px">

                                @foreach($option['map']['Layouts'] as $opt)
                                    @if($opt['Key']==$option['game_mode'])
                                        <div class="text-md uppercase text-gray-500"><span> - {{ __('app.size_'.$opt['Value']) }}</span></div>
                                    @endif
                                @endforeach
                            </div>

                        </div>
                        <button class="btn btn-primary btn-block font-bold text-black rounded-0 text-xl " wire:click="confirmVote({{ $option['id'] }})">{{ $option['map']['Name'] }}</button>

                    </div>
                @endforeach

            </div>
        </div>
    </div>

</div>
