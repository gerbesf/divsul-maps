<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="py-4">
                <div class="text-4xl font-bold card-title text-primary ">Profile</div>
                <div class=" mb-6 text-sm  text-gray-600 uppercase  "> Dashboard of your profile</div>
            </div>

            @if(request()->has('message'))
                @if(request()->get('message')=='PasswordUpdated')
                    <div class="text-green-400 p-3 border border-green-900"> Password has change </div>
                @endif
            @endif

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
                                        {{ __('logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="p-5">
                        Hello {{ Auth::user()->name }}.
                    </div>

                    <hr class="border-gray-800">
                    <div>
                        <div class="md:float-right">
                            <div class="text-gray-200 w-full  mt-4 mr-3 overflow-hidden shadow-sm sm:rounded-lg">
                                <a href="{{ route('change_password') }}" class="btn btn-primary btn-sm m-auto">Change Password</a>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="lead">Password</div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
</x-app-layout>
