<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
            Initialize <span class="text-emerald-500">Reserve Deposit</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card-premium p-8 sm:p-12">
            <div class="mb-10">
                <h3 class="text-lg font-bold text-vault-dark-900 dark:text-white flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    Deposit Protocol: {{ $user->name }}
                </h3>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-widest font-black">Verify entity
                    credentials and specify allocation amount</p>
            </div>

            <!-- Entity Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="glass p-4 rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800">
                    <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Legal Name</p>
                    <p class="text-sm font-bold text-vault-dark-900 dark:text-white truncate">{{ $user->name }}</p>
                </div>
                <div class="glass p-4 rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800">
                    <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Comms Node</p>
                    <p class="text-sm font-bold text-vault-dark-900 dark:text-white truncate">{{ $user->email }}</p>
                </div>
                <div class="glass p-4 rounded-2xl border border-gold-premium-500/20">
                    <p class="text-[10px] font-black uppercase tracking-widest text-gold-premium-500">Current Reserve
                    </p>
                    <p class="text-sm font-black text-vault-dark-900 dark:text-white">
                        {{ number_format($user->gold_balance, 2) }} <span class="text-[10px]">GRM</span></p>
                </div>
            </div>

            <!-- Deposit Form -->
            <form action="{{ route('admin.users.process-deposit', $user) }}" method="POST" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Amount -->
                    <div class="space-y-2">
                        <x-input-label for="amount" :value="__('Deposit Quantity (grams)')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <div class="relative">
                            <x-text-input id="amount" type="number" step="0.01" min="0.01" name="amount" required
                                class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-emerald-500 focus:border-emerald-500"
                                placeholder="0.00" />
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-[10px] font-black text-vault-dark-400 uppercase">Grams</span>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('amount')" />
                    </div>

                    <!-- Date -->
                    <div class="space-y-2">
                        <x-input-label for="date" :value="__('Timeline Entry (Optional)')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="date" type="datetime-local" name="date"
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-emerald-500 focus:border-emerald-500" />
                        <x-input-error :messages="$errors->get('date')" />
                        <p class="text-[10px] text-vault-dark-400 mt-1">Leave blank for current synchronized time</p>
                    </div>
                </div>

                <!-- Description -->
                <div class="space-y-2">
                    <x-input-label for="description" :value="__('Ledger Documentation')"
                        class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                    <textarea id="description" name="description" rows="3" required
                        class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-emerald-500 focus:border-emerald-500 text-sm font-bold"
                        placeholder="Document the nature of this reserve influx..."></textarea>
                    <x-input-error :messages="$errors->get('description')" />
                </div>

                <div
                    class="pt-8 border-t border-vault-dark-100 dark:border-vault-dark-800 flex flex-col sm:flex-row justify-end gap-4">
                    <button type="button" onclick="window.history.back()"
                        class="px-8 py-4 glass rounded-2xl text-[10px] font-black uppercase tracking-widest text-vault-dark-600 hover:text-vault-dark-900 transition-all text-center">
                        {{ __('Abort Deposit') }}
                    </button>
                    <button type="submit"
                        class="inline-flex items-center justify-center px-10 py-4 bg-emerald-600 hover:bg-emerald-500 text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-lg shadow-emerald-500/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        {{ __('Authorize Reserve Influx') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>