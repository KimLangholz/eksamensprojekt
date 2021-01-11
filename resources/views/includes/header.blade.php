<header x-data="{openDropdown: false, displayMobileMenu: false}" class="w-full"
    :class="{'fixed inset-0 overflow-hidden':displayMobileMenu}">
    <section id="mobile-menu-overlay" x-show="displayMobileMenu" x-cloak
        class="fixed z-50 inset-x-0 bottom-0 top-14 overflow-hidden bg-white min-h-screen min-w-screen"
        x-transition:enter="transform transition ease-in-out duration-100" x-transition:enter-start="translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transform transition ease-in-out duration-100"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full">

        <div id="mobile-menu-wrapper"
            class="flex flex-col w-full">

            @if($user->role_id === 2)
            <x-client-mobile-menu>
            </x-client-mobile-menu>
            @else
            <x-partner-mobile-menu>
            </x-partner-mobile-menu>
            @endif
        </div>

    </section>

    <section id="header" class="w-full h-14 border-gray-300 z-20" style="background-color: #005296;">

        <div class="flex flex-row justify-between items-center h-full">

            <div id="logo" class="flex-none h-12 py-2 w-auto ml-2 my-auto">
                <img src="\images\Partform-logo.png" class="h-full" alt="">
            </div>

            <div class="flex flex-row">

                <div id="menu" class="hidden sm:flex flex-row items-center cursor-pointer"
                    x-on:click="openDropdown = !openDropdown">
                    <p class="ml-4 flex mr-2 font-semibold text-white">
                        {{ $user->email }}
                    </p>

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" :class="{'rotate-180': openDropdown}"
                        class="ml-1 transform inline-block fill-current text-white w-6 h-6 mr-2">
                        <path fill-rule="evenodd"
                            d="M15.3 10.3a1 1 0 011.4 1.4l-4 4a1 1 0 01-1.4 0l-4-4a1 1 0 011.4-1.4l3.3 3.29 3.3-3.3z" />
                    </svg>

                    <div class="flex flex-col bg-white absolute top-16 lg:right-2 right-16 z-20 shadow-lg rounded-b-md w-40"
                        x-show="openDropdown"
                        x-transition:enter="transition-transform transition-opacity ease-out duration-300"
                        x-transition:enter-start="opacity-0 transform -translate-y-2"
                        x-transition:enter-end="opacity-100 transform translate-y-0"
                        x-transition:leave="transition ease-in duration-300"
                        x-transition:leave-end="opacity-0 transform -translate-y-3">
                        <a class="flex flex-row py-2 px-2 border-b hover:bg-gray-200"
                            href="{{ route('partner.settings') }}">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            Indstillinger
                        </a>
                        <div class="flex flex-row py-2 px-2 hover:bg-gray-200" href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                            Log ud
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </div>
                </div>

                <div x-show="!displayMobileMenu" class="block lg:hidden px-4 cursor-pointer">
                    <svg class="w-8 h-8 text-white hover:text-gray-300" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" x-on:click="displayMobileMenu = !displayMobileMenu">
                        <path fill-rule="evenodd"
                            d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div x-show="displayMobileMenu" class="block lg:hidden px-4 cursor-pointer">
                    <svg class="w-8 h-8  text-white hover:text-gray-300" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg" x-on:click="displayMobileMenu = !displayMobileMenu">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>

            </div>
        </div>
    </section>

</header>
