<div class="navbar mb-2 shadow-lg bg-neutral text-neutral-content rounded-box">
    <div class="flex-1 px-2 mx-2">
    <span class="text-lg font-bold">
            <a href="/">{{ env('APP_NAME') }}</a>
          </span>
    </div>{{--
    <div class="flex-none hidden px-2 mx-2 lg:flex">
        <div class="flex items-stretch">
            <a class="btn btn-ghost btn-sm rounded-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 mr-2 stroke-current"><!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                </svg>
                Likes

            </a>
            <a class="btn btn-ghost btn-sm rounded-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 mr-2 stroke-current"><!----> <!----> <!----> <!----> <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                </svg>
                Notifications

            </a>
            <a class="btn btn-ghost btn-sm rounded-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 mr-2 stroke-current"><!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                </svg>
                Files

            </a>
            <a class="btn btn-ghost btn-sm rounded-btn">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-5 mr-2 stroke-current"><!----> <!----> <!----> <!----> <!----> <!----> <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                </svg>
                Config
            </a>
        </div>
    </div>--}}
    <div class="flex-none">
        <a href="#my-modal"  class="btn btn-square btn-ghost">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
            </svg>
        </a>
        <div id="my-modal" class="modal">
            <div class="modal-box">

                <ul class="menu bg-base-100  rounded-b-none uppercase">

                    <li @if(in_array(Route::currentRouteName(),['votemap_page','votemap'])) class="bordered" @endif >
                        <a href="{{ url('/') }}" >
                            Votemap
                        </a>
                    </li>

                    <li @if(Route::currentRouteName()=='history') class="bordered" @endif >
                        <a href="{{ url('/history') }}">
                            History
                        </a>
                    </li>
                    @auth
                        <li @if(Route::currentRouteName()=='profile') class="bordered" @endif >
                            <a href="{{ url('/profile') }}">
                                Profile
                            </a>
                        </li>
                        @if(Auth::user()->level=="M")
                            <li @if(Route::currentRouteName()=='maps') class="bordered" @endif >
                                <a href="{{ url('/maps') }}">
                                    Maps
                                </a>
                            </li>
                            <li @if(Route::currentRouteName()=='admins') class="bordered" @endif  >
                                <a href="{{ url('/admins') }}">
                                    Admins
                                </a>
                            </li>
                        @endif
                    @else
                        <li @if(Route::currentRouteName()=='login') class="bordered" @endif  >
                            <a href="{{ url('/login') }}">
                                 Login
                            </a>
                        </li>

                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>

{{--
<div class="overflow-x-auto w-full">

<div class=" artboard artboard-demo rounded-none mb-5 ">
    <ul class="menu bg-base-100 horizontal rounded-b-none text-xs">

        <li @if(in_array(Route::currentRouteName(),['votemap_page','votemap'])) class="bordered" @endif >
            <a href="{{ url('/') }}" >
                Vote
            </a>
        </li>

        <li @if(Route::currentRouteName()=='history') class="bordered" @endif >
            <a href="{{ url('/history') }}">
                History
            </a>
        </li>
        @auth
        <li @if(Route::currentRouteName()=='profile') class="bordered" @endif >
            <a href="{{ url('/profile') }}">
                Profile
            </a>
        </li>
        @if(Auth::user()->level=="M")
        <li @if(Route::currentRouteName()=='maps') class="bordered" @endif >
            <a href="{{ url('/maps') }}">
                Maps
            </a>
        </li>
        <li @if(Route::currentRouteName()=='admins') class="bordered" @endif  >
            <a href="{{ url('/admins') }}">
                Admins
            </a>
        </li>
        @endif
--}}
{{--
            <a href="{{ url('/profile') }}" class="text-sm ml-4  text-neutral-content underline">Profile</a>
            <a href="{{ url('/maps') }}" class="text-sm ml-4  text-neutral-content underline">Maps</a>
            <a href="{{ url('/admins') }}" class="text-sm ml-4  text-neutral-content underline">Admins</a>--}}{{--



        @else

            <li >
                <a href="{{ url('/login') }}">
            <span>
             Login
            </span>
                </a>
            </li>

        @endif

    </ul>
</div>
</div>
--}}
{{--
<div>
    <div class="navbar mb-2  text-neutral-content ">
        --}}{{--

--}}
{{--     <div class="flex-none hidden lg:flex">
                 <button class="btn btn-square btn-ghost">
                     <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                     </svg>
                 </button>
             </div>--}}{{--
--}}
{{--

        <div class="flex-1  px-2 mx-2 lg:flex">
        <span class="text-lg font-bold">
            <a href="/">{{ env('APP_NAME') }}</a>
          </span>
        </div>--}}{{--

--}}
{{--
        <div class="flex-none">
            <button class="btn btn-square btn-ghost">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><!----> <!----> <!----> <!----> <!---->
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!----> <!---->
                </svg>
            </button>
        </div>--}}{{--
--}}
{{--

        --}}{{--

--}}
{{--
                <div class="flex-none">
                    <a href="{{ route('login') }}">
                    <div class="avatar">
                        <div class="rounded-full w-10 h-10 m-1">
                            <img src="https://avatars.dicebear.com/api/bottts/ferreira.svg">
                        </div>
                    </div>
                    </a>
                </div>
        --}}{{--
--}}
{{--


        <div class="flex-none pr-4">
            <a href="{{ url('/history') }}" class="text-sm ml-4  text-neutral-content underline">History</a>
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/profile') }}" class="text-sm ml-4  text-neutral-content underline">Profile</a>
                    <a href="{{ url('/maps') }}" class="text-sm ml-4  text-neutral-content underline">Maps</a>
                    <a href="{{ url('/admins') }}" class="text-sm ml-4  text-neutral-content underline">Admins</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm  ml-4  text-neutral-content underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-neutral-content underline">Register</a>
                    @endif
                @endauth
            @endif
        </div>



        @auth
        <div class="flex-none pr-4">
            @if (Route::has('login'))
                @else
                    <a href="{{ route('login') }}" class="text-sm  ml-4  text-neutral-content underline">Log in</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="ml-4 text-sm text-neutral-content underline">Register</a>
                    @endif
                @endauth
        </div>
        @endif


    </div>
</div>
--}}{{--


--}}
