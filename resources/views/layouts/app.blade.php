<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IOPSF') }}</title>


    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-vault-dark-50 dark:bg-vault-dark-950 text-vault-dark-900 dark:text-vault-dark-100">
    <div class="min-h-screen relative overflow-hidden">
        <!-- Ambient Background Effects -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div
                class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-gold-premium-500/5 blur-[120px] rounded-full">
            </div>
            <div
                class="absolute bottom-[20%] right-[10%] w-[30%] h-[30%] bg-gold-premium-600/5 blur-[100px] rounded-full">
            </div>
        </div>

        <!-- Navigation Bar -->
        <nav
            class="sticky top-0 z-50 glass border-b border-gold-premium-200/20 dark:border-gold-premium-800/10 backdrop-blur-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-20">
                    <div class="flex items-center">
                        <!-- Logo Area -->
                        <div class="shrink-0 flex items-center group">
                            <a href="/" class="flex items-center">
                                <div class="relative">
                                    <x-application-logo
                                        class="h-10 w-auto text-gold-premium-600 dark:text-gold-premium-400 transition-transform duration-300 group-hover:scale-110" />
                                    <div
                                        class="absolute inset-0 bg-gold-premium-500/20 blur-xl scale-150 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    </div>
                                </div>
                                <h1
                                    class="ml-3 text-2xl font-black tracking-tighter bg-gradient-to-r from-gold-premium-700 to-gold-premium-500 dark:from-gold-premium-500 dark:to-gold-premium-300 bg-clip-text text-transparent">
                                    IOPSF
                                </h1>
                            </a>
                        </div>

                        <!-- Desktop Navigation Links -->
                        <div class="hidden space-x-2 sm:ml-10 sm:flex">
                            @php
                                $dashboardRoute = auth()->user()->hasRole('admin') ? 'admin.dashboard' : 'client.dashboard';
                            @endphp
                            <x-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)"
                                class="px-4 py-2 rounded-xl border-none hover:bg-gold-premium-50/50 dark:hover:bg-gold-premium-900/10">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            @if(auth()->user()->hasRole('admin'))
                                <x-nav-link :href="route('admin.withdrawal-requests.index')"
                                    :active="request()->routeIs('admin.withdrawal-requests.*')"
                                    class="px-4 py-2 rounded-xl border-none hover:bg-gold-premium-50/50 dark:hover:bg-gold-premium-900/10">
                                    {{ __('Withdrawal Requests') }}
                                </x-nav-link>
                            @else
                                <x-nav-link :href="route('withdrawal-requests.my')"
                                    :active="request()->routeIs('withdrawal-requests.*')"
                                    class="px-4 py-2 rounded-xl border-none hover:bg-gold-premium-50/50 dark:hover:bg-gold-premium-900/10">
                                    {{ __('Withdrawals') }}
                                </x-nav-link>
                            @endif
                        </div>
                    </div>

                    <!-- User Profile Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ml-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button
                                    class="inline-flex items-center px-4 py-2 glass-premium rounded-2xl text-sm font-bold text-vault-dark-700 dark:text-vault-dark-300 hover:text-gold-premium-600 transition-all duration-300">
                                    <div class="flex items-center gap-2">
                                        <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                                        {{ explode(' ', Auth::user()->name)[0] }}
                                    </div>
                                    <svg class="ml-2 h-4 w-4 transition-transform duration-300 group-hover:rotate-180"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <div class="px-4 py-3 border-b border-vault-dark-100 dark:border-vault-dark-800">
                                    <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">
                                        Authenticated As</p>
                                    <p class="text-sm font-bold text-vault-dark-900 dark:text-white truncate">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 group">
                                    <svg class="w-4 h-4 text-vault-dark-400 group-hover:text-gold-premium-600 transition-colors"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    {{ __('Account Matrix') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();"
                                        class="flex items-center gap-2 group text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">
                                        <svg class="w-4 h-4 text-red-400 group-hover:text-red-600 transition-colors"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        {{ __('Secure Terminate') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Mobile Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-3 glass rounded-2xl text-vault-dark-500 hover:text-gold-premium-600 transition-all">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}"
                class="hidden sm:hidden glass-premium border-b border-gold-premium-200/10 animate-fade-in-up">
                <div class="pt-4 pb-6 px-4 space-y-2">
                    <x-responsive-nav-link :href="route($dashboardRoute)" :active="request()->routeIs($dashboardRoute)"
                        class="rounded-2xl border-none text-vault-dark-700 font-bold">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    @if(auth()->user()->hasRole('admin'))
                        <x-responsive-nav-link :href="route('admin.withdrawal-requests.index')"
                            :active="request()->routeIs('admin.withdrawal-requests.*')"
                            class="rounded-2xl border-none text-vault-dark-700 font-bold">
                            {{ __('Withdrawal Requests') }}
                        </x-responsive-nav-link>
                    @else
                        <x-responsive-nav-link :href="route('withdrawal-requests.my')"
                            :active="request()->routeIs('withdrawal-requests.*')"
                            class="rounded-2xl border-none text-vault-dark-700 font-bold">
                            {{ __('Withdrawals') }}
                        </x-responsive-nav-link>
                    @endif

                    <div class="pt-4 mt-4 border-t border-vault-dark-100 dark:border-vault-dark-800">
                        <div class="px-4 mb-4">
                            <p class="text-xs font-black text-vault-dark-400 uppercase tracking-widest">
                                {{ Auth::user()->name }}
                            </p>
                            <p class="text-xs text-vault-dark-500 truncate">{{ Auth::user()->email }}</p>
                        </div>
                        <x-responsive-nav-link :href="route('profile.edit')" class="rounded-2xl border-none">
                            {{ __('Account Settings') }}
                        </x-responsive-nav-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();"
                                class="text-red-500 rounded-2xl border-none">
                                {{ __('Secure Logout') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Heading -->
        @if (isset($header))
            <header class="pt-12 pb-8 px-4 sm:px-6 lg:px-8 relative z-10 animate-fade-in-up">
                <div class="max-w-7xl mx-auto">
                    <div class="glass-premium px-8 py-6 rounded-3xl border border-gold-premium-500/10 inline-block">
                        {{ $header }}
                    </div>
                </div>
            </header>
        @endif

        <!-- Main Content Area -->
        <main class="relative z-10 px-4 sm:px-6 lg:px-8 py-12 animate-fade-in-up" style="animation-delay: 0.1s;">
            <div class="max-w-7xl mx-auto">
                {{ $slot }}
            </div>
        </main>

        <!-- Global Footer -->
        <footer class="mt-auto py-12 px-8 relative z-10 border-t border-gold-premium-200/10 glass">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
                <div class="flex items-center gap-4 group">
                    <x-application-logo
                        class="h-8 w-auto text-gold-premium-600 transition-transform duration-300 group-hover:rotate-12" />
                    <span class="text-lg font-black tracking-tighter text-vault-dark-900 dark:text-white">IOPSF</span>
                </div>
                <p class="text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                    &copy; 2018 - {{ date('Y') }} IOPSF CRYPTOGRAPHIC INFRASTRUCTURE. ALL RIGHTS RESERVED.


                </p>
                <div class="flex gap-6">
                    <span class="w-3 h-3 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-emerald-600">Encrypted
                        Session</span>
                </div>
            </div>
        </footer>
    </div>
</body>

</html>