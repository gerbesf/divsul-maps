<div>

    <div class="py-5 ">
        <div class="max-w-4xl m-auto mb-5 mbx-20">

            @if($sorteado)

            <button class="btn btn-primary btn-block btn-lg font-bold mb-6" wire:click="confirmVote">Confirm Votemap</button>
            <div class="grid grid-cols-3 mb-5">
                @foreach($sorteado as $map)

                    <div class="history-card rounded bg-base-200 " styxle="background-image: url('https://www.realitymod.com/mapgallery/images/maps/{{ @$map->map->getImageKeyName() }}/banner.jpg')">
                        <div class="" >
                            <div class="rounded opacity-80 transition-all hover:opacity-100" style="background: rgba(0,0,0,0.26)">
                                <img class="" src="https://www.realitymod.com/mapgallery/images/maps/{{ \Illuminate\Support\Str::slug($map->map->getImageKeyName()) }}/mapoverview_gpm_{{ $map['game_mode'] }}_{{ $map['size'] }}.jpg">
                                <div class="p-4 ">
                                    <div class="font-bold text-xs md:text-md  text-neutral-content">{{ $map->map['Name'] }}</div>
                                    <span class="text-gray-600 text-xs">{{ __('app.size_'.$map['size']) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach
            </div>

            <div class="text-center text-lg pb-5 text-yellow-600">
                 {{ $votemap_text }}
            </div>

                <button type="button" wire:click="runSweepstakes" class="btn btn-dark btn-block mb-5">Try again</button>

            @else

                <button type="button" wire:click="runSweepstakes" class="btn btn-primary btn-block mb-5">Make Rotation Maps</button>

            @endif
        </div>
        <div class="max-w-2xl m-auto mb-5 ">
        @foreach($history as $index=>$maps)
            <div class="p-3 border border-gray-700 text-gray-400 rounded-md mb-4 text-sm">
                <span class="font-bold pb-3 pl-2 mb-4 border-b pr-2 border-gray-700  block text- w-full">Rotation <span class="text-yellow-400">#{{ $index+1 }}</span></span>
                <div class="grid md:grid-cols-3  text-center">
                    @foreach($maps as $map)
                        <div class="p-2">{{ $map }}</div>
                    @endforeach
                </div>
            </div>
        @endforeach
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            window.openZ();
            Livewire.hook('element.updating', (fromEl, toEl, component) => {
                window.openZ();
            })
            Livewire.hook('element.updated', (el, component) => {
                window.closeZ();
            })
            Livewire.hook('message.processed', (message, component) => {
                window.closeZ();
            })
        });
    </script>

</div>
