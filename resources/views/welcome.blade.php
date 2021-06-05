<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-5">
            @auth
                <ul class="steps w-full text-neutral-content">
                    <li class="step step-primary">Layout</li>
                    <li class="step">Choose</li>
                    <li class="step">Confirm</li>
                </ul>
            @endif
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4">
                @auth
                    @livewire('map-vote-laucher')
                @else
                    <div class="alert alert-info rounded-sm"> Login to start a new poll</div>
                @endif
            </div>
            @livewire('form')
            @livewire('map-view')
        </div>
    </div>

</x-app-layout>
