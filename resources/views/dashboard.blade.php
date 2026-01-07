<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard') }}
                </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Security Overview -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100">Security Overview</h3>
                        <div class="inline-flex items-center rounded-full border border-[#D4AF37]/20 bg-[#D4AF37]/10 px-3 py-1 text-sm font-medium text-[#D4AF37]">
                            <svg class="mr-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            Protected
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Last Login -->
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center">
                                <div class="rounded-lg bg-[#D4AF37]/10 p-2">
                                    <svg class="h-6 w-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100">Last Login</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">{{ auth()->user()->last_login_at?->diffForHumans() ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Security Score -->
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center">
                                <div class="rounded-lg bg-[#D4AF37]/10 p-2">
                                    <svg class="h-6 w-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100">Security Score</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Excellent</p>
                                </div>
                            </div>
                        </div>

                        <!-- 2FA Status -->
                        <div class="bg-slate-50 dark:bg-slate-900 rounded-lg p-4 border border-slate-200 dark:border-slate-700">
                            <div class="flex items-center">
                                <div class="rounded-lg bg-[#D4AF37]/10 p-2">
                                    <svg class="h-6 w-6 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-sm font-medium text-slate-900 dark:text-slate-100">2FA Status</h4>
                                    <p class="text-sm text-slate-600 dark:text-slate-400">Enabled</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-6">Recent Activity</h3>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="rounded-full bg-[#D4AF37]/10 p-2">
                                <svg class="h-5 w-5 text-[#D4AF37]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm text-slate-900 dark:text-slate-100">Successful login from {{ request()->ip() }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ now()->diffForHumans() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Section -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">My Documents</h2>
            <div class="mt-4 bg-white dark:bg-slate-800 shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse(auth()->user()->documents as $document)
                        <li class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $document->name }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Uploaded {{ $document->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('documents.download', $document) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">Download</a>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">No documents uploaded yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <!-- My Withdrawals Section -->
        <div class="mt-8">
            <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">My Withdrawals</h2>
            <div class="mt-4 bg-white dark:bg-slate-800 shadow overflow-hidden sm:rounded-md">
                <ul class="divide-y divide-slate-200 dark:divide-slate-700">
                    @forelse(auth()->user()->withdrawalRequests as $withdrawal)
                        <li class="px-6 py-4">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-slate-900 dark:text-slate-100">Amount: ${{ number_format($withdrawal->amount, 2) }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Status: {{ ucfirst($withdrawal->status) }}</p>
                                    <p class="text-sm text-slate-500 dark:text-slate-400">Requested {{ $withdrawal->created_at->diffForHumans() }}</p>
                                </div>
                                <a href="{{ route('withdrawals.show', $withdrawal) }}" class="text-sm text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">View</a>
                            </div>
                        </li>
                    @empty
                        <li class="px-6 py-4 text-sm text-slate-500 dark:text-slate-400">No withdrawal requests yet.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
