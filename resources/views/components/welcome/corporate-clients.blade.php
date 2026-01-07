@php
    $companies = [
        [
            'name' => 'Sarah Johnson',
            'logo' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Retired Teacher',
            'description' => 'Trusting IOPSF for secure retirement gold investments and easy tracking.'
        ],
        [
            'name' => 'Michael Chen',
            'logo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Software Engineer',
            'description' => 'Leveraging advanced security features for personal gold storage and access.'
        ],
        [
            'name' => 'Emily Rodriguez',
            'logo' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Financial Advisor',
            'description' => 'Recommending IOPSF to elite clients for its user-friendly platform and support.'
        ],
        [
            'name' => 'David Thompson',
            'logo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Business Owner',
            'description' => 'Utilizing real-time analytics for strategic business gold investment decisions.'
        ],
        [
            'name' => 'Lisa Wang',
            'logo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Investment Analyst',
            'description' => 'Analyzing performance through the perfect balance of security and accessibility.'
        ],
        [
            'name' => 'Robert Kim',
            'logo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'industry' => 'Retired Executive',
            'description' => 'Relying on decades of financial experience to choose IOPSF as a trusted partner.'
        ],
    ];
@endphp

<div class="py-24 sm:py-32 bg-gradient-to-b from-white to-yellow-50 dark:from-slate-900 dark:to-slate-800">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-yellow-600 dark:text-yellow-400">Trusted by Professionals</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                Corporate Clients
            </p>
            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                Discerning individuals and organizations trust IOPSF for their gold investment and vaulting requirements.
            </p>
        </div>

        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-2">
            @foreach($companies as $index => $company)
                <div class="flex flex-col group animate-fade-in-up" style="animation-delay: {{ $index * 0.1 }}s;">
                    <div
                        class="relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300 dark:bg-slate-800 border border-yellow-200 dark:border-yellow-700 hover-lift">
                        <div class="p-8">
                            <div class="flex items-center mb-6">
                                <div
                                    class="w-16 h-16 rounded-lg bg-yellow-100 dark:bg-yellow-900/20 flex items-center justify-center mr-4">
                                    <svg class="w-8 h-8 text-yellow-600 dark:text-yellow-400" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-slate-900 dark:text-white">{{ $company['name'] }}</h3>
                                    <p class="text-sm text-yellow-600 dark:text-yellow-400 font-medium">
                                        {{ $company['industry'] }}</p>
                                </div>
                            </div>

                            <p class="text-slate-600 dark:text-slate-300 mb-6">{{ $company['description'] }}</p>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    Verified Client
                                </div>
                                <div class="text-xs text-slate-400 dark:text-slate-500">
                                    Since {{ date('Y') - rand(1, 5) }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Trust Indicators -->
        <div class="mt-16 text-center">
            <div
                class="bg-white dark:bg-slate-800 rounded-2xl p-8 shadow-lg border border-yellow-200 dark:border-yellow-700">
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Why Corporations Choose IOPSF</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 dark:text-white mb-2">Enterprise Security</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Bank-level security with SOC 2 compliance
                        </p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 dark:text-white mb-2">Scalable Infrastructure</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Handles millions of transactions daily</p>
                    </div>
                    <div class="text-center">
                        <div
                            class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-lg flex items-center justify-center mx-auto mb-4">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg>
                        </div>
                        <h4 class="font-semibold text-slate-900 dark:text-white mb-2">24/7 Support</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-300">Dedicated account managers</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>