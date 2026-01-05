<nav x-data="{ open: false }" class="nav-gaming sticky top-0 z-50">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-8 h-8 bg-gaming-purple rounded-lg flex items-center justify-center glow-animation">
                            <span class="text-white font-bold text-sm">P</span>
                        </div>
                        <span class="text-xl font-bold text-gradient-purple">PummelPlay</span>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('games.index')" :active="request()->routeIs('games.*')" class="text-gray-300 hover:text-white">
                        {{ __('Games') }}
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-gray-300 hover:text-white">
                                {{ __('Admin') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')" class="text-gray-300 hover:text-white">
                                {{ __('Wishlist') }}
                            </x-nav-link>
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="text-gray-300 hover:text-white">
                                {{ __('Orders') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Side -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4 sm:ms-6">
                @auth
                    @if(auth()->user()->isCustomer())
                        <!-- Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-300 hover:text-white transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                            </svg>
                            @if(auth()->user()->cartItems()->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ auth()->user()->cartItems()->sum('quantity') }}
                                </span>
                            @endif
                        </a>
                    @endif

                    <!-- Settings Dropdown -->
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 bg-gray-700/50 hover:text-white hover:bg-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <!-- Guest Links -->
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Login</a>
                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium transition-colors">Register</a>
                @endauth
            </div>

            <!-- Mobile menu and cart -->
            <div class="flex items-center space-x-2 sm:hidden">
                @auth
                    @if(auth()->user()->isCustomer())
                        <!-- Mobile Cart -->
                        <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-300 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 4.5M21 13v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6"></path>
                            </svg>
                            @if(auth()->user()->cartItems()->count() > 0)
                                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                                    {{ auth()->user()->cartItems()->sum('quantity') }}
                                </span>
                            @endif
                        </a>
                    @endif
                @endauth
                
                <!-- Hamburger -->
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-300 hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-gray-300 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-gray-800">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('games.index')" :active="request()->routeIs('games.*')" class="text-gray-300 hover:text-white">
                {{ __('Games') }}
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->isAdmin())
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.*')" class="text-gray-300 hover:text-white">
                        {{ __('Admin Dashboard') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('wishlist.index')" :active="request()->routeIs('wishlist.*')" class="text-gray-300 hover:text-white">
                        {{ __('Wishlist') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.*')" class="text-gray-300 hover:text-white">
                        {{ __('Orders') }}
                    </x-responsive-nav-link>
                @endif
            @else
                <x-responsive-nav-link :href="route('login')" class="text-gray-300 hover:text-white">
                    {{ __('Login') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')" class="text-gray-300 hover:text-white">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        @auth
            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-gray-700">
                <div class="px-4">
                    <div class="font-medium text-base text-gray-100">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-400">{{ Auth::user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')" class="text-gray-300 hover:text-white">
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();" class="text-gray-300 hover:text-white">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            </div>
        @endauth
    </div>
</nav>
