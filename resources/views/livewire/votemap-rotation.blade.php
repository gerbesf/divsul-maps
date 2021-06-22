<div>

    <div class="py-5 ">
        <div class="max-w-4xl m-auto mb-5 mbx-20">

            @if($sorteado)

            <button class="btn btn-primary  btn-block btn-lg font-bold mb-8" wire:click="confirmVote">Confirm Votemap</button>
            <div class="grid grid-cols-3 mb-5 gap-4">
                @foreach($sorteado as $map)

                    <div class="history-card rounded bg-base-200 rounded-lg " styxle="background-image: url('https://www.realitymod.com/mapgallery/images/maps/{{ @$map->map->getImageKeyName() }}/banner.jpg')">
                        <div class="" >
                            <div class="rounded opacity-80 transition-all hover:opacity-100" style="background: rgba(0,0,0,0.26)">
                                <img class="" src="https://www.realitymod.com/mapgallery/images/maps/{{ \Illuminate\Support\Str::slug($map->map->getImageKeyName()) }}/mapoverview_gpm_{{ $map['game_mode'] }}_{{ $map['size'] }}.jpg">
                                <div class="p-4 ">
                                    <div class="font-bold text-warning text-lg text-center mxd:text-md  ">{{ $map->map['Name'] }}</div>
                           {{--         <span class="text-gray-600 text-xs">{{ __('app.size_'.$map['size']) }}</span>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
{{--
            <div class="text-center text-lg pb-5 text-2xl text-neutral-content">
                 {{ $votemap_text }}
            </div>--}}

                <button type="button" wire:click="runSweepstakes" class="btn btn-sm btn-dark btn-block text--300  rounded-sm mb-5">Try again</button>

            @else

                <button type="button" wire:click="runSweepstakes" class="btn btn-primary btn-block mb-5">Make Rotation Maps</button>

            @endif
        </div>
        <div class="max-w-4xl m-auto mb-5 ">
        @foreach($history as $index=>$maps)
            <div class="  shadow-lg bg-dark text-gray-400 rounded-md mb-4 text-sm">
                <span class="font-bold shadow pr-2 border-gray-700  bg-gray-900   block text- w-full p-3">Rotation <span class="text-yellow-400">#{{ $index+1 }}</span></span>
                <div class="grid md:grid-cols-3 text-center gap-4 p-3">
                    @foreach($maps as $map)
                        <div class="p-2 font-bold uppercase">{{ $map }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </div>


</div>
