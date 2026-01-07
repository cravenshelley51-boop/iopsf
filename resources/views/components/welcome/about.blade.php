@php
    $aboutSections = [
        [
            'title' => 'Why Invest in Gold?',
            'description' => 'Gold has been a reliable store of value for thousands of years. It provides protection against inflation, currency devaluation, and economic uncertainty.',
            'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z',
            'image' => 'https://images.unsplash.com/photo-1610375461369-d613b56394d5?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80'
        ],
        [
            'title' => 'IOPSF Advantages',
            'description' => 'Our platform offers secure storage, real-time tracking, instant withdrawals, and professional management of your gold investments.',
            'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
            'image' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80'
        ],
        [
            'title' => 'Trust & Transparency',
            'description' => 'We maintain complete transparency in all operations. Your gold is fully insured, audited regularly, and you can verify your holdings anytime.',
            'icon' => 'M9 12.75L11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 01-1.043 3.296 3.745 3.745 0 01-3.296 1.043A3.745 3.745 0 0112 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 01-3.296-1.043 3.745 3.745 0 01-1.043-3.296A3.745 3.745 0 013 12c0-1.268.63-2.39 1.593-3.068a3.746 3.746 0 011.043-3.296 3.746 3.746 0 013.296-1.043A3.746 3.746 0 0112 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 013.296 1.043 3.746 3.746 0 011.043 3.296A3.745 3.745 0 0121 12z',
            'image' => 'https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=800&q=80'
        ],
    ];
@endphp

<div id="about" class="bg-gradient-to-b from-yellow-50 to-white dark:from-slate-800 dark:to-slate-900 py-24 sm:py-32">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:mx-0 text-center lg:text-left">
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">Why Choose IOPSF?
            </h2>
            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                IOPSF, established in 2018, is your trusted partner for gold investment. We combine traditional gold
                investment benefits with modern technology to provide you with the best possible investment experience.

            </p>
        </div>

        <div class="mx-auto mt-16 max-w-2xl sm:mt-20 lg:mt-24 lg:max-w-none">
            <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                @foreach($aboutSections as $index => $section)
                    <div class="flex flex-col group animate-fade-in-up" style="animation-delay: {{ $index * 0.3 }}s;">
                        <div
                            class="relative overflow-hidden rounded-2xl bg-white shadow-lg hover:shadow-xl transition-all duration-300 dark:bg-slate-800 border border-yellow-200 dark:border-yellow-700 hover-lift">
                            <!-- Section Image -->
                            <div class="aspect-w-16 aspect-h-9 overflow-hidden">
                                <img src="{{ $section['image'] }}" alt="{{ $section['title'] }}"
                                    class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>

                            <div class="p-8">
                                <dt
                                    class="flex items-center gap-x-3 text-xl font-semibold leading-7 text-slate-900 dark:text-white mb-4">
                                    <div
                                        class="flex h-12 w-12 items-center justify-center rounded-lg bg-yellow-100 dark:bg-yellow-900/20 group-hover:bg-yellow-200 dark:group-hover:bg-yellow-800/30 transition-colors duration-200">
                                        <svg class="h-7 w-7 text-yellow-600 dark:text-yellow-400" viewBox="0 0 24 24"
                                            fill="none" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="{{ $section['icon'] }}" />
                                        </svg>
                                    </div>
                                    {{ $section['title'] }}
                                </dt>
                                <dd
                                    class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600 dark:text-slate-300">
                                    <p class="flex-auto">{{ $section['description'] }}</p>
                                </dd>
                            </div>
                        </div>
                    </div>
                @endforeach
            </dl>
        </div>

        <!-- Call to Action -->
        <div class="mt-16 text-center">
            <div class="bg-gradient-to-r from-yellow-600 to-yellow-500 rounded-2xl p-8 shadow-xl">
                <h3 class="text-2xl font-bold text-white mb-4">Ready to Start Your Gold Investment Journey?</h3>
                <p class="text-yellow-100 mb-6 text-lg">Join thousands of investors who trust IOPSF with their gold
                    investments.</p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('login') }}"
                        class="bg-white text-yellow-600 px-8 py-3 rounded-lg font-semibold hover:bg-yellow-50 transition-colors duration-200">
                        Get Started
                    </a>
                    <a href="#features"
                        class="border-2 border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-yellow-600 transition-colors duration-200">
                        Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>