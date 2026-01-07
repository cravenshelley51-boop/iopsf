<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'IOPSF') }} - Admin Matrix</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-vault-dark-50 dark:bg-vault-dark-950 text-vault-dark-900 dark:text-vault-dark-100">
    <div class="min-h-screen flex relative overflow-hidden">
        <!-- Ambient Background Effects -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div class="absolute -top-[5%] -left-[5%] w-[35%] h-[35%] bg-gold-premium-500/5 blur-[120px] rounded-full">
            </div>
            <div
                class="absolute bottom-[10%] right-[10%] w-[45%] h-[45%] bg-gold-premium-600/5 blur-[150px] rounded-full">
            </div>
        </div>

        <!-- Sidebar -->
        <div class="hidden md:flex md:w-72 md:flex-col relative z-20">
            <div
                class="flex flex-col flex-grow glass border-r border-gold-premium-200/20 dark:border-gold-premium-800/10 shadow-2xl h-full">
                <!-- Logo Area -->
                <div class="flex items-center flex-shrink-0 px-8 py-10">
                    <div class="flex items-center group">
                        <div class="relative">
                            <x-application-logo
                                class="h-10 w-auto text-gold-premium-600 dark:text-gold-premium-400 transition-transform duration-300 group-hover:scale-110" />
                            <div
                                class="absolute inset-0 bg-gold-premium-500/20 blur-xl scale-150 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </div>
                        <div class="ml-4">
                            <h1
                                class="text-2xl font-black tracking-tighter bg-gradient-to-r from-gold-premium-700 to-gold-premium-500 dark:from-gold-premium-500 dark:to-gold-premium-300 bg-clip-text text-transparent">
                                VAULT
                            </h1>
                            <p class="text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">Control
                                Panel</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="flex-1 px-4 space-y-2 mt-4">
                    @php
                        $adminNavItems = [
                            ['route' => 'admin.dashboard', 'label' => 'Strategic Overview', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                            ['route' => 'admin.users.index', 'label' => 'Identity Matrix', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z'],
                            ['route' => 'admin.documents.index', 'label' => 'Audit Archives', 'icon' => 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                            ['route' => 'admin.settings', 'label' => 'System Core', 'icon' => 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z'],
                        ];
                    @endphp

                    @foreach($adminNavItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="{{ request()->routeIs($item['route'] . '*') ? 'bg-gold-premium-500 text-white shadow-lg shadow-gold-premium-500/20' : 'text-vault-dark-500 dark:text-vault-dark-400 hover:bg-gold-premium-50/50 dark:hover:bg-gold-premium-900/10 hover:text-gold-premium-600 dark:hover:text-gold-premium-400' }} group flex items-center px-4 py-3.5 text-sm font-bold rounded-2xl transition-all duration-300">
                            <svg class="mr-3 h-5 w-5 transition-transform duration-300 group-hover:scale-110" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="{{ $item['icon'] }}"></path>
                            </svg>
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                </nav>

                <!-- Admin Auth Area -->
                <div
                    class="p-6 m-4 glass-premium rounded-3xl border border-gold-premium-200/30 dark:border-gold-premium-800/30">
                    <div class="flex items-center">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold-premium-600 to-gold-premium-400 flex items-center justify-center text-white shadow-lg">
                            <span class="text-sm font-black">{{ substr(Auth::user()->name, 0, 1) }}</span>
                        </div>
                        <div class="ml-3 flex-1 overflow-hidden">
                            <p
                                class="text-xs font-black text-vault-dark-900 dark:text-white truncate uppercase tracking-tight">
                                {{ Auth::user()->name }}
                            </p>
                            <div class="flex items-center gap-1.5 mt-0.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <p class="text-[10px] text-emerald-600 font-black uppercase tracking-widest">Root</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="ml-2">
                            @csrf
                            <button type="submit"
                                class="p-2 glass rounded-xl text-vault-dark-400 hover:text-red-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Portal Area -->
        <div class="flex-1 flex flex-col relative z-10 overflow-y-auto">
            <!-- Mobile Interface -->
            <div
                class="md:hidden glass border-b border-gold-premium-200/20 dark:border-gold-premium-800/10 px-6 py-4 flex items-center justify-between">
                <div class="flex items-center">
                    <x-application-logo class="h-8 w-auto text-gold-premium-600" />
                    <span
                        class="ml-3 text-xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">Vault</span>
                </div>
            </div>

            @if (isset($header))
                <header class="pt-16 pb-8 px-8">
                    <div class="max-w-7xl mx-auto">
                        <div class="animate-fade-in-up">
                            {{ $header }}
                        </div>
                    </div>
                </header>
            @endif

            <main class="py-12 px-8 flex-1 animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>
</body>

</html>