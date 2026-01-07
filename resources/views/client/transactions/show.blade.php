<x-client-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-slate-900 dark:text-white leading-tight">
                {{ __('Transaction Details') }}
            </h2>
            <a href="{{ route('client.transactions.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-slate-500 hover:bg-slate-600 border border-transparent rounded-lg font-semibold text-sm text-white uppercase tracking-wider focus:outline-none focus:ring-2 focus:ring-slate-500 transition-all duration-200">
                Back to Transactions
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 shadow-lg sm:rounded-xl border border-yellow-200 dark:border-yellow-700 overflow-hidden">
                <div class="p-6">
                    <dl class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Transaction ID</dt>
                            <dd class="mt-1 text-sm text-slate-900 dark:text-white">#{{ $transaction->id }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Date</dt>
                            <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ $transaction->created_at->format('M d, Y H:i') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Type</dt>
                            <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ ucfirst($transaction->type) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Amount</dt>
                            <dd class="mt-1 text-lg font-semibold text-slate-900 dark:text-white">${{ number_format($transaction->amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Payment Method</dt>
                            <dd class="mt-1 text-sm text-slate-900 dark:text-white">{{ ucfirst(str_replace('_', ' ', $transaction->payment_method)) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-slate-500 dark:text-slate-400">Status</dt>
                            <dd class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $transaction->status === 'pending' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/20 dark:text-yellow-400' : 
                                       ($transaction->status === 'completed' ? 'bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400' : 'bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400') }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>
