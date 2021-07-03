<x-app-layout>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">SETUP</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  ">Configure connection with server</div>
            </div>

            @if($server)


                <div class=" bg-neutral p-6 rounded shadow">

            <form action="{{ route('setup_update') }}" method="post">
                <div class=" text-xl  text-gray-400 uppercase  ">{{ $server->name }}</div>
                @csrf
                <h4 class="text-gray-400 pt-4 pb-3">Hash Server</h4>
                <div>
                    <x-label for="hash_endpoint" :value="__('Url of hash file')" />

                    <x-input id="hash_endpoint" class="block mt-1 w-full text-white" type="text" name="hash_endpoint" value="{{ $server->hash_endpoint }}" required autofocus />
                </div>

                <h4 class="text-gray-400 pt-4 pb-3">Http Auth</h4>
                <div>
                    <x-label for="http_username" :value="__('Username')" />

                    <x-input id="http_username" class="block mt-1 w-full text-white" type="text" name="http_username" value="{{ $server->http_username }}" />
                </div>

                <div>
                    <x-label for="http_password" :value="__('Password')" />

                    <x-input id="http_password" class="block mt-1 w-full text-white" type="text" name="http_password" value="{{ $server->http_password }}"  />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-button>
                        {{ __('Update Hash Server') }}
                    </x-button>
                </div>

            </form>
                </div>
            @endif

            <div class=" mb-6 text-sm  text-gray-600 uppercase mt-4  ">Avaliable Servers</div>
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
