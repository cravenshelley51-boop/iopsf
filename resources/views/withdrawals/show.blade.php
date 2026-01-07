<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Withdrawal Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Amount -->
                        <div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Amount</h3>
                            <p class="mt-1 text-2xl font-semibold text-[#D4AF37]">${{ number_format($withdrawal->amount, 2) }}</p>
                        </div>

                        <!-- Status -->
                        <div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Status</h3>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($withdrawal->status === 'approved') bg-green-100 text-green-800
                                    @elseif($withdrawal->status === 'pending') bg-yellow-100 text-yellow-800
                                    @else bg-red-100 text-red-800
                                    @endif">
                                    {{ ucfirst($withdrawal->status) }}
                                </span>
                            </p>
                        </div>

                        <!-- Requested At -->
                        <div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Requested</h3>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $withdrawal->created_at->format('F j, Y g:i A') }}</p>
                        </div>

                        <!-- Last Updated -->
                        <div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Last Updated</h3>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $withdrawal->updated_at->format('F j, Y g:i A') }}</p>
                        </div>

                        @if($withdrawal->notes)
                        <!-- Notes -->
                        <div>
                            <h3 class="text-lg font-medium text-slate-900 dark:text-slate-100">Notes</h3>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">{{ $withdrawal->notes }}</p>
                        </div>
                        @endif
                    </div>

                    <div class="mt-6">
                        @if(auth()->user()->hasRole('admin'))
                            <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 dark:bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-white focus:bg-slate-700 dark:focus:bg-white active:bg-slate-900 dark:active:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                Back to Dashboard
                            </a>
                        @else
                            <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-800 dark:bg-slate-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-slate-800 uppercase tracking-widest hover:bg-slate-700 dark:hover:bg-white focus:bg-slate-700 dark:hover:bg-white active:bg-slate-900 dark:active:bg-slate-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 transition ease-in-out duration-150">
                                Back to Dashboard
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 