<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">SETUP</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  ">Select actual server</div>
            </div>

            <div>
                @foreach($servers as $item)

                    <div class="p-4 border  border-base-200 hover:shadow my-4 text-neutral-content rounded-lg transition-all hover:bg-base-200">
                        <div class="flex gap-5">
                            <div class="flex-col text-gray-500">
                                {{ $item->countryFlag }}
                            </div>
                            <div class="flex-col flex-grow ">
                                <div class="font-bold text-primary">{{ $item->properties->hostname }}</div>
                                <div class="text-gray-400">{{ __('app.'.str_replace('gpm_','',$item->properties->gametype)) }} | {{ $item->properties->mapname }} </div>
                            </div>
                            <div class="flex-col">
                                <span class="pl-2 text-gray-700">Players: </span> {{ $item->properties->numplayers }} /
                                {{ $item->properties->maxplayers }}
                            </div>
                            <div class="flex-col">
                                <a href="/setup?id={{ $item->serverId }}" class="btn btn-primary btn-sm">Select</a>
                            </div>
                        </div>
                    </div>

                @endforeach
                 {{--   @foreach($servers as $item)

                        <pre>{{ print_r($item) }}</pre>
                    @endforeach--}}
            </div>

        </div>
    </div>
</x-app-layout>
