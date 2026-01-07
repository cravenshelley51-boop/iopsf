<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="IOPSF - The world's most secure digital vault for physically backed gold reserves.">

    <title>{{ config('app.name', 'IOPSF') }} | Secure Vault</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="bg-vault-dark-950 font-sans antialiased text-vault-dark-100 min-h-screen overflow-x-hidden selection:bg-gold-premium-500 selection:text-white">
    <div class="relative min-h-screen flex flex-col items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Ambient Background Effects -->
        <div class="fixed inset-0 pointer-events-none overflow-hidden z-0">
            <div
                class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-gold-premium-600/10 blur-[150px] rounded-full animate-pulse-slow">
            </div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-gold-premium-400/10 blur-[150px] rounded-full animate-pulse-slow"
                style="animation-delay: 2s;"></div>
        </div>

        <!-- Header / Logo Area -->
        <div class="relative z-10 w-full max-w-md text-center mb-12 animate-fade-in-up">
            <a href="/" class="inline-flex flex-col items-center group">
                <div class="relative mb-6">
                    <x-application-logo
                        class="h-16 w-auto text-gold-premium-500 transition-transform duration-500 group-hover:scale-110" />
                    <div
                        class="absolute inset-0 bg-gold-premium-500/20 blur-2xl scale-150 opacity-0 group-hover:opacity-100 transition-opacity duration-700">
                    </div>
                </div>
                <h1
                    class="text-4xl font-black tracking-tighter bg-gradient-to-br from-gold-premium-400 via-gold-premium-200 to-gold-premium-500 bg-clip-text text-transparent underline-offset-8 decoration-gold-premium-500/30">
                    SECURE VAULT
                </h1>
                <p class="mt-2 text-xs font-black uppercase tracking-[0.4em] text-vault-dark-400">Institutional Grade
                    Custody</p>
            </a>
        </div>

        <!-- Content Slot -->
        <main class="relative z-10 w-full max-w-md animate-fade-in-up" style="animation-delay: 0.2s;">
            <div
                class="glass-premium p-10 rounded-[2.5rem] border border-gold-premium-500/10 shadow-[0_35px_60px_-15px_rgba(0,0,0,0.3)]">
                {{ $slot }}
            </div>
        </main>

        <!-- Footer Area -->
        <footer class="relative z-10 w-full max-w-md mt-12 text-center animate-fade-in-up"
            style="animation-delay: 0.4s;">
            <p class="text-xs font-bold text-vault-dark-500 uppercase tracking-widest">
                &copy; 2018 - {{ date('Y') }} {{ config('app.name') }} Security Systems. All Rights Reserved.

            </p>
            <div class="mt-4 flex justify-center gap-6">
                <a href="#"
                    class="text-[10px] font-black uppercase tracking-widest text-vault-dark-600 hover:text-gold-premium-500 transition-colors">Privacy
                    Protocol</a>
                <a href="#"
                    class="text-[10px] font-black uppercase tracking-widest text-vault-dark-600 hover:text-gold-premium-500 transition-colors">Legal
                    Terms</a>
            </div>
        </footer>
    </div>
</body>

</html>