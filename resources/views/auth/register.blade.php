<x-guest-layout>
    <div class="w-full max-w-md mx-auto">
        <div class="bg-white dark:bg-slate-800 shadow-2xl rounded-3xl p-10 border border-yellow-400/20 text-center">
            <div class="mb-8 flex justify-center">
                <div class="p-4 bg-yellow-400/10 rounded-full">
                    <svg class="w-12 h-12 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>

            <h2 class="text-3xl font-black text-slate-900 dark:text-white mb-4 tracking-tight">Registration Restricted
            </h2>
            <p class="text-slate-600 dark:text-slate-400 text-lg leading-relaxed mb-8">
                New accounts can only be created by system administrators. If you are a new customer, please wait for an
                invitation email from the IOPSF platform.
            </p>

            <div class="pt-6 border-t border-slate-100 dark:border-slate-700">
                <a href="{{ route('login') }}"
                    class="inline-flex items-center text-yellow-600 dark:text-yellow-400 hover:text-yellow-700 dark:hover:text-yellow-300 font-bold transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Login
                </a>
            </div>
        </div>

    </div>
</x-guest-layout>