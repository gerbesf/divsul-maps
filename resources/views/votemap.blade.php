<x-app-layout>

    @auth
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
                <ul class="steps w-full text-neutral-content">
                    <li class="step step-primary">Layout</li>
                    <li class="step step-primary">Choose</li>
                    <li class="step @if($votemap) step-primary @endif ">Confirm</li>
                </ul>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="p-4">
                    @auth
                        @livewire('chronometer')
                        <div class="grid grid-cols-2 text-lg text-neutral-content text-center py-5">
                            <div>{{ __('app.'.$layout) }}</div>
                            <div>{{ str_replace('_',' at ',$players)  }} players</div>
                        </div>

                        @if(!$votemap)
                            @livewire('votemap-rotation')
                        @endif
                        @if($votemap)
                            @livewire('votemap-confirmation')
                        @endif

                    @else
                        <div class="alert alert-info rounded-sm"> Login to start a new poll</div>
                    @endif
                </div>
            </div>
        </div>
    @endif

</x-app-layout>
