<!-- File: layouts/superadmin-sidebar.blade.php -->
<div x-data="sidebarHandler()" x-init="init()" class="relative h-full">
    <!-- Overlay -->
    <!-- Overlay -->
    <div x-show="open && isMobile" x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="fixed inset-0 bg-black bg-opacity-50 z-40 md:hidden" @click="close()">
    </div>

    <!-- Header (Fixed Top) -->
    <header class="fixed top-0 left-0 w-full z-50 bg-white shadow-md md:pl-4 h-20 flex items-center">
        <div class="flex items-center space-x-3 w-full">
            <button x-show="isMobile" class="p-4 focus:outline-none" @click="toggle()" aria-label="Toggle sidebar">
                <svg class="w-6 h-6 text-gray-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                    height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 6h8m-8 4h12M6 14h8m-8 4h12" />
                </svg>
            </button>
            <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 ml-4">
                <img src="/telkom.png" alt="NJKI TELKOM" class="h-20 mt-2  text-xl text-red-700 w-auto">
                {{-- <p class="text-xl font-extrabold text-red-700">NJ <span class="font-extrabold text-black">KI</span>
                </p> --}}

            </a>
        </div>
    </header>

    <!-- Sidebar -->
    <aside x-show="open || !isMobile" x-transition:enter="transition ease-in-out duration-300"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in-out duration-300" x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
        :class="{ 'translate-x-0': open || !isMobile, '-translate-x-full': !open && isMobile }"
        class="fixed top-20 left-0 h-[calc(100vh-5rem)] w-64 bg-white shadow-lg flex flex-col z-40 transform transition-transform duration-300 ease-in-out"
        @click.away="isMobile && close()">

        <nav class="flex-1 bg-white px-4 space-y-2 overflow-y-auto">
            <p class="text-red-800 text-center font-medium mt-6 mb-6">
                Hello, {{ auth()->user()->name }}</p>
            <h2 class="text-gray-900 text-xs font-extralight border-b uppercase mt-4 px-4 py-2">Admin Menu</h2>
            <x-nav-link href="{{ route('superadmin.dashboard') }}" :active="request()->routeIs('superadmin.dashboard')"
                class="w-full box-border text-lg flex items-center px-4 py-2 text-red-800 hover:bg-red-300 hover:font-semibold transition duration-150 ease-in-out rounded-lg"
                @click="isMobile && close()">
                <svg class="w-6 h-6 text-red-800 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 8v8m0-8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 8a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V9a3 3 0 0 0-3-3h-3m1.5-2-2 2 2 2" />
                </svg>

                Dashboard
            </x-nav-link>
            <x-nav-link href="{{ route('superadmin.users') }}" :active="request()->routeIs('superadmin.users')"
                class="w-full box-border text-lg items-center px-4 py-2 text-red-800 hover:bg-red-400 rounded-lg"
                @click="isMobile && close()">
                <svg class="w-6 h-6 text-red-800 mr-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-width="2"
                        d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>


                Users
            </x-nav-link>
            <x-nav-link href="{{ route('superadmin.bandwidth') }}" :active="request()->routeIs('superadmin.bandwidth')"
                class="w-full box-border text-lg items-center px-4 py-2 text-red-800 hover:bg-red-400 rounded-lg"
                @click="isMobile && close()">
                <svg class="mr-3 w-6 h-6 " xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#8c0303"
                        d="M576 0c17.7 0 32 14.3 32 32l0 448c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-448c0-17.7 14.3-32 32-32zM448 96c17.7 0 32 14.3 32 32l0 352c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-352c0-17.7 14.3-32 32-32zM352 224l0 256c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-256c0-17.7 14.3-32 32-32s32 14.3 32 32zM192 288c17.7 0 32 14.3 32 32l0 160c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-160c0-17.7 14.3-32 32-32zM96 416l0 64c0 17.7-14.3 32-32 32s-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32s32 14.3 32 32z" />
                </svg>
                Bandwidths
            </x-nav-link>
            <x-nav-link href="{{ route('superadmin.items') }}" :active="request()->routeIs('superadmin.items')"
                class="w-full box-border text-lg items-center px-4 py-2 text-red-800 hover:bg-red-400 rounded-lg"
                @click="isMobile && close()">
                <svg class="mr-3 w-5 h-5" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#8c0303"
                        d="M40 48C26.7 48 16 58.7 16 72l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24L40 48zM192 64c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32L192 64zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zm0 160c-17.7 0-32 14.3-32 32s14.3 32 32 32l288 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-288 0zM16 232l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0c-13.3 0-24 10.7-24 24zM40 368c-13.3 0-24 10.7-24 24l0 48c0 13.3 10.7 24 24 24l48 0c13.3 0 24-10.7 24-24l0-48c0-13.3-10.7-24-24-24l-48 0z" />
                </svg>
                Items
            </x-nav-link>
            <x-nav-link href="{{ route('superadmin.investment.archive.index') }}" :active="request()->routeIs('superadmin.investment.archive.index')"
                class="w-full box-border text-lg items-center px-4 py-2 text-red-800 hover:bg-red-400 rounded-lg"
                @click="isMobile && close()">
                <svg class="w-6 h-6 mr-3 text-red-800 " aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                    width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linejoin="round" stroke-width="2"
                        d="M10 12v1h4v-1m4 7H6a1 1 0 0 1-1-1V9h14v9a1 1 0 0 1-1 1ZM4 5h16a1 1 0 0 1 1 1v2a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1Z" />
                </svg>

                Archived Investments
            </x-nav-link>


            <h2 class="text-red-800 text-xs font-extralight border-b uppercase px-4 py-2 mt-4">Settings</h2>
            <x-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')"
                class="w-full box-border text-lg flex items-center px-4 py-2 text-red-800 hover:bg-red-300 hover:font-semibold transition duration-150 ease-in-out rounded-lg"
                @click="isMobile && close()">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                Profile
            </x-nav-link>
            {{-- <h2 class="text-red-800 text-xs font-extralight border-b uppercase px-4 py-2 mt-4">Menu Master</h2>
            <x-nav-link href="{{ route('superadmin.masterkapal') }}" :active="request()->routeIs('superadmin.masterkapal')"
                class="w-full box-border text-lg flex items-center px-4 py-2 text-red-800 hover:bg-red-300 hover:font-semibold transition duration-150 ease-in-out rounded-lg"
                @click="isMobile && close()">
                <svg class="mr-3 h-6 w-6" xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#ffffff"
                        d="M192 32c0-17.7 14.3-32 32-32L352 0c17.7 0 32 14.3 32 32l0 32 48 0c26.5 0 48 21.5 48 48l0 128 44.4 14.8c23.1 7.7 29.5 37.5 11.5 53.9l-101 92.6c-16.2 9.4-34.7 15.1-50.9 15.1c-19.6 0-40.8-7.7-59.2-20.3c-22.1-15.5-51.6-15.5-73.7 0c-17.1 11.8-38 20.3-59.2 20.3c-16.2 0-34.7-5.7-50.9-15.1l-101-92.6c-18-16.5-11.6-46.2 11.5-53.9L96 240l0-128c0-26.5 21.5-48 48-48l48 0 0-32zM160 218.7l107.8-35.9c13.1-4.4 27.3-4.4 40.5 0L416 218.7l0-90.7-256 0 0 90.7zM306.5 421.9C329 437.4 356.5 448 384 448c26.9 0 55.4-10.8 77.4-26.1c0 0 0 0 0 0c11.9-8.5 28.1-7.8 39.2 1.7c14.4 11.9 32.5 21 50.6 25.2c17.2 4 27.9 21.2 23.9 38.4s-21.2 27.9-38.4 23.9c-24.5-5.7-44.9-16.5-58.2-25C449.5 501.7 417 512 384 512c-31.9 0-60.6-9.9-80.4-18.9c-5.8-2.7-11.1-5.3-15.6-7.7c-4.5 2.4-9.7 5.1-15.6 7.7c-19.8 9-48.5 18.9-80.4 18.9c-33 0-65.5-10.3-94.5-25.8c-13.4 8.4-33.7 19.3-58.2 25c-17.2 4-34.4-6.7-38.4-23.9s6.7-34.4 23.9-38.4c18.1-4.2 36.2-13.3 50.6-25.2c11.1-9.4 27.3-10.1 39.2-1.7c0 0 0 0 0 0C136.7 437.2 165.1 448 192 448c27.5 0 55-10.6 77.5-26.1c11.1-7.9 25.9-7.9 37 0z" />
                </svg>

                Master Kapal
            </x-nav-link>
            <x-nav-link href="{{ route('superadmin.masterkade') }}" :active="request()->routeIs('superadmin.masterkade')"
                class="w-full box-border text-lg flex items-center px-4 py-2 text-red-800 hover:bg-red-300 hover:font-semibold transition duration-150 ease-in-out rounded-lg"
                @click="isMobile && close()">
                <svg class="mr-3 w-6 h-6"xmlns="http://www.w3.org/2000/svg"
                    viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.-->
                    <path fill="#ffffff"
                        d="M320 96a32 32 0 1 1 -64 0 32 32 0 1 1 64 0zm21.1 80C367 158.8 384 129.4 384 96c0-53-43-96-96-96s-96 43-96 96c0 33.4 17 62.8 42.9 80L224 176c-17.7 0-32 14.3-32 32s14.3 32 32 32l32 0 0 208-48 0c-53 0-96-43-96-96l0-6.1 7 7c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9L97 263c-9.4-9.4-24.6-9.4-33.9 0L7 319c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l7-7 0 6.1c0 88.4 71.6 160 160 160l80 0 80 0c88.4 0 160-71.6 160-160l0-6.1 7 7c9.4 9.4 24.6 9.4 33.9 0s9.4-24.6 0-33.9l-56-56c-9.4-9.4-24.6-9.4-33.9 0l-56 56c-9.4 9.4-9.4 24.6 0 33.9s24.6 9.4 33.9 0l7-7 0 6.1c0 53-43 96-96 96l-48 0 0-208 32 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-10.9 0z" />
                </svg>

                Master Kade
            </x-nav-link> --}}
            <form method="POST" action="{{ route('logout') }}" class="flex items-center w-full"
                @submit.prevent="$event.target.submit();">
                @csrf
                <button type="submit"
                    class="mt-12 font-bold text-lg w-full box-border flex items-center px-4 py-2 bg-red-700 text-white hover:bg-red-400 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Log Out
                </button>
            </form>
        </nav>
    </aside>
</div>

<script>
    function sidebarHandler() {
        return {
            open: false,
            isMobile: false,

            init() {
                // Set initial state based on screen size
                this.checkIfMobile();

                // Listen for window resize events
                window.addEventListener('resize', () => {
                    this.checkIfMobile();
                });
            },

            checkIfMobile() {
                const wasMobile = this.isMobile;
                this.isMobile = window.innerWidth < 768;

                // If changing from mobile to desktop, ensure sidebar is open
                if (wasMobile && !this.isMobile) {
                    this.open = true;
                }

                // If changing from desktop to mobile, ensure sidebar is closed
                if (!wasMobile && this.isMobile) {
                    this.open = false;
                }
            },

            toggle() {
                this.open = !this.open;
            },

            close() {
                if (this.isMobile) {
                    this.open = false;
                }
            }
        };
    }
</script>
