<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">Maps configuration</div>
            </div>

            <div class="">
                @foreach($levels as $item)

                    <div class="card card-body bg-base-100 mb-4 text-gray-400">
                        <div class="text-2xl">{{ $item->Name }}
                            <span>{{ $item->Size }} KM</span>
                        </div>
                        <div class="grid grid-cols-2 @if(count($item->Layouts)>=6) md:grid-cols-6 @else md:grid-cols-5 @endif gap-4">

                            @foreach($item->Layouts as $layoutBlock)

                                @if($layoutBlock['Key']!="coop")
                                    <div class="pb-2" >
                                        <img src="https://www.realitymod.com/mapgallery/images/maps/{{ \Illuminate\Support\Str::slug($item->getImageKeyName()) }}/mapoverview_gpm_{{ $layoutBlock['Key'] }}_{{ $layoutBlock['Value'] }}.jpg">

                                        <div class="py-4 font-bold">
                                            <a class="" href="https://www.realitymod.com/mapgallery/#!/{{ \Illuminate\Support\Str::slug($item->getImageKeyName()) }}/gpm_{{ $layoutBlock['Key'] }}/{{ $layoutBlock['Value'] }}" target="_blank">
                                                <div>{{ __('app.'.$layoutBlock['Key']) }} <small> {{ __('app.size_'.$layoutBlock['Value']) }}</small></div>
                                            </a>
                                        </div>
                                        <div class="">
                                            @foreach($filters['Players'] as $player)
                                                <div class="flex-grow">
                                                    @livewire('admin.map-checkbox',[$item->Key,$layoutBlock['Key'], $layoutBlock['Value'] , $player])
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>

</x-app-layout>
