<x-guest-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">History</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  "> Limit of days: <b>{{ $days_limit }} @if($days_limit==1) day @else days @endif </b></div>
            </div>

        <div class="text-neutral-content m-auto">
            @foreach($collection as $item)
                <div class="history-card rounded m-2"
                     @if($item->map)
                     style="background-image: url('https://www.realitymod.com/mapgallery/images/maps/{{ @$item->map->getImageKeyName() }}/banner.jpg')" @endif>

                        <div class="rounded p-4 @if($item->valid) border border-gray-800 @else opacity-30 @endif " style="background: rgba(0,0,0,0.51)">       <div class="grid md:grid-cols-2">

                            <div title="" class="font-bold @if($item->valid) text-yellow-500 @else text-gray-200 @endif text-2xl">
                                {{ $item->name }}
                            </div>
                            <div>
                                <div class="text-gray-300  md:float-right p-1 px-2">{{ $item->players ?: '0'}}/100</div>
                                <span class="badge badge-dark my-1 md:float-right">{{ \Carbon\Carbon::parse($item->timestamp)->diffForHumans() }}</span>
                                <span class="badge @if($item->map_mode=="skirmish") badge-dark @else badge-primary @endif my-1 md:float-right"> {{ __('app.'.$item->map_mode) }}</span>
                            </div>
                            {{--{{ \Carbon\Carbon::parse($item->timestamp)->format('d/m H:i') }}
                                                      <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($item->timestamp)->format('d/m H:i') }}</div>
                            --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    </div>


</x-guest-layout>
