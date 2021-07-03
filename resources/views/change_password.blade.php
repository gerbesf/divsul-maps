<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">Change password</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  "></div>
            </div>
            <div class="text-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3  text-neutral-content ">

                    <form action="{{ route('doChangePassword') }}" method="post">
                        @csrf
                            <div>
                                <x-label for="password" :value="__('Password')" />

                                <x-input id="password" class="block mt-1 w-full" type="password" name="password" value="" required autofocus />
                            </div>
                            <div class="mt-3">
                                <x-label for="password_confirmed" :value="__('Confirm Password')" />

                                <x-input id="password_confirmed" class="block mt-1 w-full" type="password" name="password_confirmed" />
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-button>
                                    {{ __('Change password') }}
                                </x-button>
                            </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
