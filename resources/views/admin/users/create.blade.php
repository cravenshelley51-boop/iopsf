<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
            Initialize <span class="text-gold-premium-600">New Identity</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="card-premium p-8 sm:p-12">
            <div class="mb-10">
                <h3 class="text-lg font-bold text-vault-dark-900 dark:text-white flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gold-premium-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gold-premium-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                        </svg>
                    </div>
                    Onboarding Configuration
                </h3>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-widest font-black">Define credentials and
                    secure access parameters</p>
            </div>

            <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-8">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Name -->
                    <div class="space-y-2">
                        <x-input-label for="name" :value="__('Legal Name')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500" />
                        <x-input-error :messages="$errors->get('name')" />
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <x-input-label for="email" :value="__('Communication Node (Email)')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="email" type="email" name="email" :value="old('email')" required
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500" />
                        <x-input-error :messages="$errors->get('email')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Password -->
                    <div class="space-y-2">
                        <x-input-label for="password" :value="__('Security Key (Password)')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="password" type="password" name="password" required
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500" />
                        <x-input-error :messages="$errors->get('password')" />
                    </div>

                    <!-- Confirm Password -->
                    <div class="space-y-2">
                        <x-input-label for="password_confirmation" :value="__('Key Verification')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="password_confirmation" type="password" name="password_confirmation" required
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500" />
                        <x-input-error :messages="$errors->get('password_confirmation')" />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Initial Gold Balance -->
                    <div class="space-y-2">
                        <x-input-label for="gold_balance" :value="__('Initial Reserve Allocation (oz)')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <x-text-input id="gold_balance" type="number" step="0.01" name="gold_balance"
                            :value="old('gold_balance', 0)" required
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500" />
                        <x-input-error :messages="$errors->get('gold_balance')" />
                    </div>

                    <!-- Role -->
                    <div class="space-y-2">
                        <x-input-label for="role" :value="__('System Clearances')"
                            class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400" />
                        <select id="role" name="role"
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl focus:ring-gold-premium-500 focus:border-gold-premium-500 text-sm font-bold">
                            <option value="client">CIVILIAN CLIENT</option>
                            <option value="admin">ROOT ADMINISTRATOR</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" />
                    </div>
                </div>

                <div
                    class="pt-8 border-t border-vault-dark-100 dark:border-vault-dark-800 flex flex-col sm:flex-row justify-end gap-4">
                    <button type="button" onclick="window.history.back()"
                        class="px-8 py-4 glass rounded-2xl text-[10px] font-black uppercase tracking-widest text-vault-dark-600 hover:text-vault-dark-900 transition-all text-center">
                        {{ __('Abort Protocol') }}
                    </button>
                    <button type="submit" class="btn-premium px-10 py-4">
                        {{ __('Initialize Matrix Entry') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>