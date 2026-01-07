<x-guest-layout>
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-yellow-50 via-white to-yellow-50 dark:from-slate-900 dark:via-slate-800 dark:to-slate-900">
        <!-- Background Pattern -->
        <div class="absolute inset-0 bg-[url('data:image/svg+xml,%3Csvg width=" 60" height="60" viewBox="0 0 60 60"
            xmlns="http://www.w3.org/2000/svg" %3E%3Cg fill="none" fill-rule="evenodd" %3E%3Cg fill="%23D4AF37"
            fill-opacity="0.05" %3E%3Ccircle cx="30" cy="30" r="4" /%3E%3C/g%3E%3C/g%3E%3C/svg%3E')] opacity-50"></div>

        <div
            class="relative w-full sm:max-w-md mt-6 px-6 py-8 bg-white dark:bg-slate-800 shadow-2xl overflow-hidden sm:rounded-2xl border border-yellow-200 dark:border-yellow-700">
            <!-- Animated Background -->
            <div class="absolute inset-0 bg-gradient-to-r from-yellow-400/10 via-yellow-500/5 to-yellow-400/10"></div>
            <div class="absolute -top-4 -right-4 w-24 h-24 bg-yellow-400/20 rounded-full blur-2xl"></div>
            <div class="absolute -bottom-4 -left-4 w-32 h-32 bg-yellow-600/20 rounded-full blur-2xl"></div>

            <!-- Logo Section -->
            <div class="relative mb-8 flex justify-center">
                <div class="relative">
                    <div
                        class="absolute -inset-2 rounded-full bg-gradient-to-r from-yellow-400 to-yellow-600 opacity-20 blur-lg animate-pulse">
                    </div>
                    <div class="relative">
                        <x-welcome.logo class="h-16 w-auto" />
                    </div>
                </div>
            </div>

            <!-- Welcome Text -->
            <div class="relative mb-8 text-center">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">Welcome Back</h2>
                <p class="text-slate-600 dark:text-slate-400">Sign in to your IOPSF account</p>
            </div>

            <!-- Security Badge -->
            <div class="relative mb-8 flex justify-center">
                <div
                    class="inline-flex items-center rounded-full border border-yellow-400/30 bg-yellow-400/10 px-4 py-2 text-sm font-medium text-yellow-700 dark:text-yellow-300 shadow-lg">
                    <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                    Secure Authentication
                </div>
            </div>

            <!-- Form Section -->
            <div class="relative">
                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')"
                            class="text-slate-700 dark:text-slate-300 font-medium" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207">
                                    </path>
                                </svg>
                            </div>
                            <x-text-input id="email"
                                class="block w-full pl-10 pr-3 py-3 border-slate-300 dark:border-slate-600 focus:border-yellow-500 focus:ring-yellow-500 dark:bg-slate-700 dark:text-white rounded-lg"
                                type="email" name="email" :value="old('email')" required autofocus
                                autocomplete="username" placeholder="Enter your email" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Password')"
                            class="text-slate-700 dark:text-slate-300 font-medium" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                    </path>
                                </svg>
                            </div>
                            <x-text-input id="password"
                                class="block w-full pl-10 pr-3 py-3 border-slate-300 dark:border-slate-600 focus:border-yellow-500 focus:ring-yellow-500 dark:bg-slate-700 dark:text-white rounded-lg"
                                type="password" name="password" required autocomplete="current-password"
                                placeholder="Enter your password" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>



                    <div class="flex items-center justify-end">
                        @if (Route::has('password.request'))
                            <a class="text-sm text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 font-medium"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-700 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 transform hover:scale-105 transition-all duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                </path>
                            </svg>
                            {{ __('Sign In') }}
                        </button>
                    </div>
                </form>


            </div>
        </div>

        <!-- Trust Indicators -->
        <div class="mt-8 text-center">
            <div class="flex items-center justify-center space-x-8 text-sm text-slate-500 dark:text-slate-400">
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    Bank-level Security
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    256-bit Encryption
                </div>
                <div class="flex items-center">
                    <svg class="w-4 h-4 mr-1 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd" />
                    </svg>
                    24/7 Support
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>