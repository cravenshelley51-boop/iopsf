<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IOPSF') }} - Client Portal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-vault-dark-50 dark:bg-vault-dark-950 text-vault-dark-900 dark:text-vault-dark-100">
    <div class="min-h-screen relative overflow-x-hidden">
        <!-- Ambient Background -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div
                class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-gold-premium-500/10 blur-[120px] rounded-full animate-pulse">
            </div>
            <div
                class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-gold-premium-600/5 blur-[100px] rounded-full delay-700">
            </div>
            <div
                class="absolute bottom-0 left-[20%] w-[50%] h-[50%] bg-gold-premium-400/5 blur-[150px] rounded-full delay-1000">
            </div>
        </div>

        <!-- Content -->
        <div class="relative z-10 flex flex-col min-h-screen">
            <!-- Navigation -->
            <nav
                class="sticky top-0 z-50 transition-all duration-300 glass border-b border-gold-premium-200/20 dark:border-gold-premium-800/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-20">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                <a href="{{ route('client.dashboard') }}" class="flex items-center group">
                                    <div class="relative">
                                        <x-application-logo
                                            class="h-10 w-auto text-gold-premium-600 dark:text-gold-premium-400 transition-transform duration-300 group-hover:scale-110" />
                                        <div
                                            class="absolute inset-0 bg-gold-premium-500/20 blur-xl scale-150 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                        </div>
                                    </div>
                                    <h1
                                        class="ml-3 text-2xl font-bold tracking-tight bg-gradient-to-r from-gold-premium-700 to-gold-premium-500 dark:from-gold-premium-500 dark:to-gold-premium-300 bg-clip-text text-transparent">
                                        IOPSF
                                    </h1>
                                </a>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-1 ml-12 sm:flex">
                                <x-nav-link :href="route('client.dashboard')"
                                    :active="request()->routeIs('client.dashboard')"
                                    class="px-4 py-2 rounded-xl transition-all duration-200">
                                    {{ __('Dashboard') }}
                                </x-nav-link>
                                <x-nav-link :href="route('client.documents.index')"
                                    :active="request()->routeIs('client.documents.*')"
                                    class="px-4 py-2 rounded-xl transition-all duration-200 relative group">
                                    {{ __('Documents') }}
                                    @if(Auth::user()->documents()->doesntExist())
                                        <span
                                            class="absolute top-2 right-2 block h-2 w-2 rounded-full bg-red-500 ring-4 ring-white dark:ring-vault-dark-900 group-hover:animate-ping"></span>
                                    @endif
                                </x-nav-link>
                                <x-nav-link :href="route('withdrawal-requests.my')"
                                    :active="request()->routeIs('withdrawal-requests.*')"
                                    class="px-4 py-2 rounded-xl transition-all duration-200">
                                    {{ __('Withdrawals') }}
                                </x-nav-link>
                                <x-nav-link :href="route('client.profile')"
                                    :active="request()->routeIs('client.profile')"
                                    class="px-4 py-2 rounded-xl transition-all duration-200">
                                    {{ __('Profile') }}
                                </x-nav-link>
                            </div>
                        </div>

                        <!-- Settings Dropdown -->
                        <div class="hidden sm:flex sm:items-center">
                            <x-dropdown align="right" width="48">
                                <x-slot name="trigger">
                                    <button
                                        class="inline-flex items-center px-4 py-2 glass rounded-2xl border border-gold-premium-200/30 dark:border-gold-premium-800/30 hover:bg-gold-premium-50/50 dark:hover:bg-gold-premium-900/10 transition-all duration-200 group">
                                        <div
                                            class="w-8 h-8 rounded-full bg-gradient-to-br from-gold-premium-200 to-gold-premium-100 dark:from-gold-premium-900 dark:to-gold-premium-800 flex items-center justify-center mr-3 border border-gold-premium-300/50 dark:border-gold-premium-700/50 shadow-inner">
                                            <svg class="w-4 h-4 text-gold-premium-700 dark:text-gold-premium-300"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </div>
                                        <span
                                            class="text-sm font-semibold tracking-tight">{{ Auth::user()->name }}</span>
                                        <svg class="ml-2 h-4 w-4 transition-transform duration-200 group-hover:translate-y-0.5"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                </x-slot>

                                <x-slot name="content">
                                    <div class="px-4 py-3 border-b border-vault-dark-100 dark:border-vault-dark-700">
                                        <p class="text-xs text-vault-dark-500 uppercase font-bold tracking-widest">
                                            Signed in as</p>
                                        <p class="text-sm font-semibold truncate">{{ auth()->user()->email }}</p>
                                    </div>
                                    <x-dropdown-link :href="route('client.profile')">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            {{ __('My Profile') }}
                                        </div>
                                    </x-dropdown-link>

                                    <!-- Authentication -->
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault(); this.closest('form').submit();"
                                            class="text-red-500 hover:bg-red-50 dark:hover:bg-red-900/10">
                                            <div class="flex items-center">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                                </svg>
                                                {{ __('Sign Out') }}
                                            </div>
                                        </x-dropdown-link>
                                    </form>
                                </x-slot>
                            </x-dropdown>
                        </div>

                        <!-- Mobile Hamburger -->
                        <div class="-mr-2 flex items-center sm:hidden">
                            <button @click="open = ! open"
                                class="inline-flex items-center justify-center p-2.5 rounded-xl glass text-vault-dark-500 dark:text-vault-dark-400 hover:text-gold-premium-600 dark:hover:text-gold-premium-400 focus:outline-none transition duration-200">
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
                    class="hidden sm:hidden glass-premium border-t border-gold-premium-200/20 dark:border-gold-premium-800/20">
                    <div class="pt-4 pb-3 space-y-1">
                        <x-responsive-nav-link :href="route('client.dashboard')"
                            :active="request()->routeIs('client.dashboard')">
                            {{ __('Dashboard') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('client.documents.index')"
                            :active="request()->routeIs('client.documents.*')">
                            <span class="flex items-center justify-between w-full">
                                {{ __('Documents') }}
                                @if(Auth::user()->documents()->doesntExist())
                                    <span class="h-2 w-2 rounded-full bg-red-500"></span>
                                @endif
                            </span>
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('withdrawal-requests.my')"
                            :active="request()->routeIs('withdrawal-requests.*')">
                            {{ __('Withdrawals') }}
                        </x-responsive-nav-link>
                        <x-responsive-nav-link :href="route('client.profile')"
                            :active="request()->routeIs('client.profile')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>
                    </div>

                    <div class="pt-4 pb-1 border-t border-vault-dark-200 dark:border-vault-dark-700">
                        <div class="px-4 flex items-center mb-4">
                            <div
                                class="w-10 h-10 rounded-full bg-gold-premium-100 dark:bg-gold-premium-900 flex items-center justify-center border border-gold-premium-200 dark:border-gold-premium-800 mr-3">
                                <svg class="w-5 h-5 text-gold-premium-600 dark:text-gold-premium-400" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <div class="font-bold text-base text-vault-dark-900 dark:text-vault-dark-100">
                                    {{ Auth::user()->name }}
                                </div>
                                <div class="font-medium text-sm text-vault-dark-500">{{ Auth::user()->email }}</div>
                            </div>
                        </div>

                        <div class="space-y-1 px-4 pb-4">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 bg-red-500/10 dark:bg-red-500/5 text-red-600 dark:text-red-400 rounded-xl font-bold flex items-center">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    {{ __('Sign Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            @if (isset($header))
                <header class="relative overflow-hidden pt-12 pb-8">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main class="flex-grow pb-16">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="py-12 glass border-t border-gold-premium-200/20 dark:border-gold-premium-800/10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                    <div class="flex items-center justify-center space-x-2 mb-4">
                        <x-application-logo class="h-6 w-auto text-gold-premium-500 opacity-50" />
                        <span
                            class="text-xl font-bold bg-gradient-to-r from-gold-premium-700 to-gold-premium-500 dark:from-gold-premium-500 dark:to-gold-premium-300 bg-clip-text text-transparent opacity-50">IOPSF</span>
                    </div>
                    <p class="text-vault-dark-500 text-sm">&copy; {{ date('Y') }} Institutional Online Precious Stone
                        Finance. Secured by Vault Protocol.</p>
                </div>
            </footer>
        </div>
    </div>
</body>

</html>