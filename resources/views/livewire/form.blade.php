<div>
    <div class="p-4">

        @foreach($filters as $filter)

            <div class="mb-4">
                @if($filter['name']=='Mods')
                    <div class="text-gray-500 text-sm  mb-3 font-thin uppercase">{{ $filter['name'] }}
                        @if($mods)
                            <button type="button" wire:click="resetMods" class="btn btn-dark ml-2 btn-xs">Reset</button>
                        @endif
                    </div>
                @else
                    <div class="text-gray-500 text-sm  mb-3 font-thin uppercase">{{ $filter['name'] }}</div>
                @endif

                <div class="grid md:grid-cols-{{ count($filter['settings']) }} grid-cols-2  gap-4">
                    @foreach($filter['settings'] as $settings)

                        <label  class="p-3 rounded border border-neutral transition-all hover:bg-gray-700 @if(${strtolower($filter['name'])}==$settings['code']) bg-neutral @endif" >
                            <input class="form-check-input mr-2" wire:model="{{ strtolower($filter['name']) }}" name="{{ md5($filter['id']) }}" type="radio" value="{{ $settings['code'] }}">
                            @if($filter['name']=='Players')
                                <span class="form-check-label text-xs md:text-md  @if(${strtolower($filter['name'])}==$settings['code']) text-white font-bold @else text-gray-600 @endif"> {{ $settings['name']  }} Players</span>
                            @else
                                <span class="form-check-label text-xs md:text-md  @if(${strtolower($filter['name'])}==$settings['code']) text-white font-bold @else text-gray-600  @endif"> {{ __('app.'.$settings['name']) }} </span>
                            @endif
                        </label>

                    @endforeach
                </div>
            </div>

        @endforeach

    </div>
</div>
