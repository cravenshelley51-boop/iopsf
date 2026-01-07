<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
                    Entity <span class="text-gold-premium-600">Details</span>
                </h2>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-[0.3em] font-black">Profile Specification
                </p>
            </div>
            <div class="flex gap-4">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn-premium px-8 py-3">
                    {{ __('Modify Profile') }}
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="glass px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-vault-dark-700">
                    {{ __('Return to Matrix') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Identity Profile -->
            <div class="card-premium p-8">
                <div class="flex flex-col items-center text-center">
                    <div
                        class="w-24 h-24 rounded-3xl bg-gold-premium-500/10 flex items-center justify-center text-gold-premium-600 mb-6 border border-gold-premium-500/20">
                        <span class="text-4xl font-black">{{ substr($user->name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-2xl font-black text-vault-dark-900 dark:text-white uppercase">{{ $user->name }}</h3>
                    <p class="text-vault-dark-400 font-bold uppercase tracking-widest text-[10px] mt-2">
                        {{ $user->email }}</p>

                    <div
                        class="w-full mt-8 p-4 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Security
                                Clearance</span>
                            <span
                                class="px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase">Level
                                1</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span
                                class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Status</span>
                            <span class="flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase text-emerald-600">Active Node</span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Asset Capacity -->
            <div class="lg:col-span-2 space-y-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="card-premium p-8">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gold-premium-500 mb-2">Allocated
                            Reserves</p>
                        <div class="flex items-end gap-2">
                            <span
                                class="text-4xl font-black text-vault-dark-900 dark:text-white">{{ number_format($user->gold_balance, 2) }}</span>
                            <span class="mb-1 text-xs font-black text-vault-dark-400">OZ</span>
                        </div>
                        <p class="mt-4 text-[10px] font-bold text-vault-dark-400 uppercase tracking-tighter">Current
                            market valuation pending</p>
                    </div>

                    <div class="card-premium p-8">
                        <div class="flex items-center justify-between mb-2">
                            <p class="text-[10px] font-black uppercase tracking-widest text-purple-500">Vault
                                Allocation</p>
                            <span class="text-[10px] font-black uppercase text-vault-dark-400">{{ $user->vaults()->count() }} / 100 MAX</span>
                        </div>
                        <div class="flex items-end gap-2 mb-6">
                            <span
                                class="text-4xl font-black text-vault-dark-900 dark:text-white">{{ $user->vaults()->count() }}</span>
                            <span class="mb-1 text-xs font-black text-vault-dark-400">UNITS</span>
                        </div>
                        
                        <!-- Vault List -->
                        @if($user->vaults()->count() > 0)
                            <div class="space-y-3 mb-8 max-h-48 overflow-y-auto pr-2 custom-scrollbar">
                                @foreach($user->vaults as $vault)
                                    <div class="flex items-center justify-between p-3 rounded-xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-600">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="text-[10px] font-black text-vault-dark-900 dark:text-white uppercase">{{ $vault->vault_identifier }}</p>
                                                <p class="text-[8px] text-vault-dark-400 uppercase font-bold">{{ $vault->capacity }}kg Capacity</p>
                                            </div>
                                        </div>
                                        <form action="{{ route('admin.users.unassign-vault', [$user, $vault]) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 hover:text-red-500 transition-colors" onclick="return confirm('Unassign this vault?')">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <!-- Allocation Form -->
                        <form action="{{ route('admin.users.assign-vault', $user) }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="flex gap-2">
                                <input type="number" name="quantity" value="1" min="1" max="10" 
                                    class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-xl text-xs font-bold focus:ring-purple-500 focus:border-purple-500">
                                <button type="submit" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-xl text-[10px] font-black uppercase tracking-widest transition-all">
                                    Allocate
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Recent Ledger Entries -->
                <div class="card-premium p-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-vault-dark-500 mb-8">Transaction
                        Intelligence</h3>
                    <div class="space-y-4">
                        @forelse($user->transactions()->latest()->take(5)->get() as $tx)
                            <div
                                class="p-4 rounded-2xl glass flex items-center justify-between border border-transparent hover:border-gold-premium-500/20 transition-all">
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-900 flex items-center justify-center text-vault-dark-400">
                                        @if($tx->type == 'credit')
                                            <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M7 11l5-5m0 0l5 5m-5-5v12" />
                                            </svg>
                                        @else
                                            <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 13l-5 5m0 0l-5-5m5 5V6" />
                                            </svg>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">
                                            {{ $tx->description }}</p>
                                        <p class="text-[10px] text-vault-dark-400 uppercase tracking-tighter">
                                            {{ $tx->created_at->format('d M Y - H:i') }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p
                                        class="text-sm font-black {{ $tx->type == 'credit' ? 'text-emerald-500' : 'text-red-500' }}">
                                        {{ $tx->type == 'credit' ? '+' : '-' }}{{ number_format($tx->amount, 2) }}
                                    </p>
                                    <p class="text-[10px] font-bold text-vault-dark-400 uppercase tracking-tighter">SECURE
                                        TRX</p>
                                </div>
                            </div>
                        @empty
                            <div class="py-12 text-center">
                                <p class="text-xs font-bold text-vault-dark-400 uppercase tracking-widest">No matching
                                    ledger entries</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>