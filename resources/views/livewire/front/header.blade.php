<header class="bg-amber-100 shadow-md">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex h-16 items-center justify-between">
            <!-- Left Logo -->
            <div class="flex items-center">
                <a href="/" class="flex items-center">
                    <img src="{{ asset('images/Logo.png') }}" alt="Logo" class="h-16 sm:h-32">
                </a>
            </div>

            <!-- Hamburger Mobile -->
            <div class="sm:hidden flex items-center">
                <button id="mobile-menu-button" class="text-amber-800 focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Centered Navbar -->
            <nav class="hidden sm:flex absolute left-1/2 transform -translate-x-1/2" aria-label="Global">
                <ul class="flex items-center space-x-4 md:space-x-6 text-sm font-semibold">
                    <li>
                        <a wire:navigate href="/"
                            class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                            Home
                        </a>
                    </li>
                    <li>
                        @auth
                            @if (auth()->user()->is_admin)
                                <a wire:navigate href="/roomTypeTable"
                                    class="relative px-3 py-2 text-amber-800 
                after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:w-0 after:h-[2px] after:bg-amber-800 
                after:transition-all after:duration-300 after:ease-in-out
                hover:after:w-full">
                                    Room Type List
                                </a>
                            @else
                                <a wire:navigate href="/roomTypeList"
                                    class="relative px-3 py-2 text-amber-800 
                after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:w-0 after:h-[2px] after:bg-amber-800 
                after:transition-all after:duration-300 after:ease-in-out
                hover:after:w-full">
                                    Room Type
                                </a>
                            @endif
                        @endauth

                        @guest
                            <a wire:navigate href="/roomTypeList"
                                class="relative px-3 py-2 text-amber-800 
            after:content-[''] after:absolute after:left-0 after:bottom-0 
            after:w-0 after:h-[2px] after:bg-amber-800 
            after:transition-all after:duration-300 after:ease-in-out
            hover:after:w-full">
                                Room Type
                            </a>
                        @endguest
                    </li>

                    <li>
                        @auth
                            @if (auth()->user()->is_admin)
                                <a wire:navigate href="/hotelList"
                                    class="relative px-3 py-2 text-amber-800 
                after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:w-0 after:h-[2px] after:bg-amber-800 
                after:transition-all after:duration-300 after:ease-in-out
                hover:after:w-full">
                                    Hotel List
                                </a>
                            @else
                                <a wire:navigate href="/hotelAll"
                                    class="relative px-3 py-2 text-amber-800 
                after:content-[''] after:absolute after:left-0 after:bottom-0 
                after:w-0 after:h-[2px] after:bg-amber-800 
                after:transition-all after:duration-300 after:ease-in-out
                hover:after:w-full">
                                    Hotel
                                </a>
                            @endif
                        @endauth

                        @guest
                            <a wire:navigate href="/hotelAll"
                                class="relative px-3 py-2 text-amber-800 
            after:content-[''] after:absolute after:left-0 after:bottom-0 
            after:w-0 after:h-[2px] after:bg-amber-800 
            after:transition-all after:duration-300 after:ease-in-out
            hover:after:w-full">
                                Hotel
                            </a>
                        @endguest
                    </li>

                    <li>
                        @auth
                            @if (auth()->user()->is_admin)
                                <a wire:navigate href="/roomList"
                                    class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                                    Room List
                                </a>
                            @else
                                <a wire:navigate href="/about"
                                    class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                                    About Us
                                </a>
                            @endif
                        @endauth

                        @guest
                            <a wire:navigate href="/about"
                                class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                                About Us
                            </a>
                        @endguest
                    </li>
                    <li>
                        @auth
                            @if (auth()->user()->is_admin)
                                <a wire:navigate href="/bookingList"
                                    class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                                    Booking List
                                </a>
                            @else
                                <a wire:navigate href="/bookingDetails"
                                    class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all  after:duration-300 after:ease-in-out
          hover:after:w-full">
                                    Booking
                                </a>
                            @endif
                        @endauth

                        @guest
                            <a wire:navigate href="#"
                                class="relative px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all  after:duration-300 after:ease-in-out
          hover:after:w-full">
                                Booking
                            </a>
                        @endguest
                    </li>
                </ul>
            </nav>

            <!-- Right Side -->
            <div class="hidden sm:flex items-center gap-3">
                @guest
                    <a href="{{ route('login') }}"
                        class="relative font-bold text-sm px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                        Login
                    </a>
                    <a href="{{ route('register') }}"
                        class="relative font-bold text-sm px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                        Register
                    </a>
                @endguest

                @auth
                    {{-- <a wire:navigate href="{{ route('dashboard') }}"
                        class="relative font-bold text-sm px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                        Profile
                    </a> --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="relative font-bold text-sm px-3 py-2 text-amber-800 
          after:content-[''] after:absolute after:left-0 after:bottom-0 
          after:w-0 after:h-[2px] after:bg-amber-800 
          after:transition-all after:duration-300 after:ease-in-out
          hover:after:w-full">
                            Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="sm:hidden hidden mt-2">
            <ul class="flex flex-col space-y-2 text-sm font-semibold">
                <li><a wire:navigate href="/" class="px-3 py-2 text-amber-800 block">Home</a></li>
                <li><a wire:navigate href="/roomTypeList" class="px-3 py-2 text-amber-800 block">Room Type</a></li>
                <li><a wire:navigate href="/hotelAll" class="px-3 py-2 text-amber-800 block">Hotel</a></li>
                <li><a wire:navigate href="/about" class="px-3 py-2 text-amber-800 block">About Us</a></li>
                <li><a wire:navigate href="#" class="px-3 py-2 text-amber-800 block">Booking</a></li>
                @guest
                    <li><a href="{{ route('login') }}" class="px-3 py-2 text-amber-800 block">Login</a></li>
                    <li><a href="{{ route('register') }}" class="px-3 py-2 text-amber-800 block">Register</a></li>
                @endguest
                @auth
                    <li><a wire:navigate href="{{ route('dashboard') }}" class="px-3 py-2 text-amber-800 block">Profile</a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="px-3 py-2 text-amber-800 w-full text-left">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</header>

<script>
    const btn = document.getElementById('mobile-menu-button');
    const menu = document.getElementById('mobile-menu');

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
    });
</script>
