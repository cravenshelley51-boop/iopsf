@php
    $testimonials = [
        [
            'name' => 'Sarah Johnson',
            'role' => 'Retired Teacher',
            'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'IOPSF has made gold investment so easy and secure. I can track my investments in real-time and the withdrawal process is incredibly smooth.',
            'rating' => 5
        ],
        [
            'name' => 'Michael Chen',
            'role' => 'Software Engineer',
            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'The security features are impressive. I feel confident knowing my gold is stored safely and I can access it whenever I need.',
            'rating' => 5
        ],
        [
            'name' => 'Emily Rodriguez',
            'role' => 'Financial Advisor',
            'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'I recommend IOPSF to all my clients. The platform is user-friendly and the customer support is exceptional.',
            'rating' => 5
        ],
        [
            'name' => 'David Thompson',
            'role' => 'Business Owner',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'The real-time tracking and analytics help me make informed investment decisions. Great platform for serious investors.',
            'rating' => 5
        ],
        [
            'name' => 'Lisa Wang',
            'role' => 'Investment Analyst',
            'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'IOPSF offers the perfect balance of security and accessibility. The mobile app makes managing investments on-the-go effortless.',
            'rating' => 5
        ],
        [
            'name' => 'Robert Kim',
            'role' => 'Retired Executive',
            'image' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=400&q=80',
            'content' => 'After 30 years in finance, I can say IOPSF is one of the most reliable gold investment platforms I\'ve ever used.',
            'rating' => 5
        ],
    ];
@endphp

<div class="py-24 sm:py-32 bg-white dark:bg-slate-900">
    <div class="mx-auto max-w-7xl px-6 lg:px-8">
        <div class="mx-auto max-w-2xl lg:text-center">
            <h2 class="text-base font-semibold leading-7 text-yellow-600 dark:text-yellow-400">Testimonials</h2>
            <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                What Our Investors Say
            </p>
            <p class="mt-6 text-lg leading-8 text-slate-600 dark:text-slate-300">
                Join thousands of satisfied investors who trust IOPSF with their gold investments.
            </p>
        </div>

        <div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-8 sm:mt-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">
            @foreach($testimonials as $index => $testimonial)
                <div class="flex flex-col justify-between bg-white dark:bg-slate-800 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 border border-yellow-200 dark:border-yellow-700 p-8 hover-lift animate-fade-in-up"
                    style="animation-delay: {{ $index * 0.1 }}s;">
                    <div class="flex-1">
                        <!-- Rating -->
                        <div class="flex items-center mb-4">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $testimonial['rating'] ? 'text-yellow-400' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>

                        <!-- Content -->
                        <blockquote class="text-lg leading-8 text-slate-600 dark:text-slate-300 mb-6">
                            "{{ $testimonial['content'] }}"
                        </blockquote>
                    </div>

                    <!-- Author -->
                    <div class="flex items-center">
                        <img class="h-12 w-12 rounded-full object-cover" src="{{ $testimonial['image'] }}"
                            alt="{{ $testimonial['name'] }}">
                        <div class="ml-4">
                            <div class="text-base font-semibold text-slate-900 dark:text-white">{{ $testimonial['name'] }}
                            </div>
                            <div class="text-sm text-slate-600 dark:text-slate-400">{{ $testimonial['role'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Stats Section -->
        <div class="mt-16 bg-gradient-to-r from-yellow-600 to-yellow-500 rounded-2xl p-8 text-center">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="text-3xl font-bold text-white">4.9/5</div>
                    <div class="text-yellow-100">Average Rating</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">10,000+</div>
                    <div class="text-yellow-100">Happy Investors</div>
                </div>
                <div>
                    <div class="text-3xl font-bold text-white">99.9%</div>
                    <div class="text-yellow-100">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</div>