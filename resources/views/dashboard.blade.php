<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">Profile</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  "> Dashboard of your profile</div>
            </div>
            <div class="text-gray-200 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-3 bg-base-100 text-neutral-content ">
                    <div class="md:float-right">
                        <div class="text-gray-200 w-full  mt-4 mr-3 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class=" ">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm m-auto" :href="route('logout')"
                                            onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                        {{ __('Click here for logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        Hello {{ Auth::user()->name }}.
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
