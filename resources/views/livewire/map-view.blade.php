<div>

    @auth
    @if(count($zmaps)>=3)
        @livewire('map-vote-laucher',[false,$layout,$players])
    @else
        @livewire('map-vote-laucher',[true,$layout,$players])
    @endif
    @endif

    <div class="p-4">
        <div class="text-gray-500 text-sm  mb-3 font-thin uppercase"> @if(count($zmaps)) Avaliable Maps: {{ count($zmaps) }} @endif</div>
        <div class=" ">
            @if(count($reality_maps)==0)
                <div class="text-center text-gray-600">No have maps in rotation</div>
            @endif
            <div class="grid md:grid-cols-6 grid-cols-2 gap-4">
                @foreach($reality_maps as $map)
                    <div class="">
                        <div class="history-card rounded  @if($map['unavaliable']) opacity-40   @else border border-green-900  @endif" styxle="background-image: url('https://www.realitymod.com/mapgallery/images/maps/{{ @$map->map->getImageKeyName() }}/banner.jpg')">
                            <div class="" >
                                <div class="rounded opacity-80 transition-all hover:opacity-100" style="background: rgba(0,0,0,0.26)">
                                    <a class="" href="https://www.realitymod.com/mapgallery/#!/{{ \Illuminate\Support\Str::slug($map->map->getImageKeyName()) }}/gpm_{{ $map['game_mode'] }}/{{ $map['size'] }}"
                                       target="_blank">
                                        <img class="" src="https://www.realitymod.com/mapgallery/images/maps/{{ \Illuminate\Support\Str::slug($map->map->getImageKeyName()) }}/mapoverview_gpm_{{ $map['game_mode'] }}_{{ $map['size'] }}.jpg">
                                    </a>
                                    <div class="p-4 ">
                                        <div class="font-bold text-xs md:text-md  text-neutral-content">{{ $map->map['Name'] }}</div>
                                        <span class="text-gray-600 text-xs">{{ __('app.size_'.$map['size']) }}</span>
                                        {{-- {{ $map['avaliable'] }}--}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>
