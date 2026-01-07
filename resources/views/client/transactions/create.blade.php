<x-client-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-slate-900 dark:text-white leading-tight">
            {{ __('New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="max-w-2xl mx-auto">
                <div
                    class="bg-white dark:bg-slate-800 shadow-lg sm:rounded-xl border border-yellow-200 dark:border-yellow-700 p-6">
                    <form action="{{ route('client.transactions.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="bg-blue-50 dark:bg-blue-900/30 border-l-4 border-blue-400 p-4 mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p
                                        class="text-xs text-blue-700 dark:text-blue-300 font-bold uppercase tracking-wider">
                                        Seeking Gold Liquidation?
                                    </p>
                                    <p class="text-[10px] text-blue-600 dark:text-blue-400 mt-1 uppercase font-medium">
                                        To withdraw your gold reserves (Ounces), please use the <a
                                            href="{{ route('withdrawal-requests.create') }}"
                                            class="underline decoration-2 underline-offset-2 hover:text-blue-800 transition-colors">Outflux
                                            Protocol</a>.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2" for="type">
                                Transaction Type
                            </label>
                            <select name="type" id="type"
                                class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('type') border-red-500 @enderror"
                                required>
                                <option value="">Select Transaction Type</option>
                                <option value="deposit" {{ old('type') === 'deposit' ? 'selected' : '' }}>Deposit</option>
                                <option value="withdrawal" {{ old('type') === 'withdrawal' ? 'selected' : '' }}>Withdrawal
                                </option>
                            </select>
                            @error('type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"
                                for="amount">
                                Amount
                            </label>
                            <div class="relative">
                                <span
                                    class="absolute inset-y-0 left-0 pl-3 flex items-center text-slate-500 dark:text-slate-400">$</span>
                                <input type="number" step="0.01" min="1" name="amount" id="amount"
                                    value="{{ old('amount') }}"
                                    class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 py-2 px-3 pl-8 focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('amount') border-red-500 @enderror"
                                    placeholder="0.00" required>
                            </div>
                            @error('amount')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2"
                                for="payment_method">
                                Payment Method
                            </label>
                            <select name="payment_method" id="payment_method"
                                class="w-full rounded-lg border border-slate-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-slate-900 dark:text-slate-100 py-2 px-3 focus:outline-none focus:ring-2 focus:ring-yellow-500 @error('payment_method') border-red-500 @enderror"
                                required>
                                <option value="">Select Payment Method</option>
                                <option value="bank_transfer" {{ old('payment_method') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="crypto" {{ old('payment_method') === 'crypto' ? 'selected' : '' }}>
                                    Cryptocurrency</option>
                            </select>
                            @error('payment_method')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end space-x-4 pt-4">
                            <a href="{{ route('client.transactions.index') }}"
                                class="px-4 py-2 bg-slate-500 hover:bg-slate-600 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-500 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-4 py-2 bg-gradient-to-r from-yellow-600 to-yellow-500 hover:from-yellow-700 hover:to-yellow-600 text-white font-medium rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500 transition-all duration-200">
                                Create Transaction
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-client-layout>