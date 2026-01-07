<x-client-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 animate-fade-in-up">
            <div>
                <h2 class="text-4xl font-bold tracking-tight text-vault-dark-900 dark:text-white leading-tight">
                    Welcome back, <span
                        class="bg-gradient-to-r from-gold-premium-600 to-gold-premium-400 bg-clip-text text-transparent">{{ explode(' ', auth()->user()->name)[0] }}</span>
                </h2>
                <p class="text-lg text-vault-dark-500 font-medium mt-2">Manage your secure gold reserves and documents.
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('client.documents.create') }}" class="btn-premium flex items-center gap-2 group">
                    <svg class="w-5 h-5 transition-transform duration-300 group-hover:rotate-90" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    <span>Upload Documents</span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 space-y-12" x-data="{
        balanceVisible: @js(auth()->user()->balance_visibility),
        pin: '',
        loading: false,
        errorMessage: '',
        toggleBalance() {
            if (this.balanceVisible) {
                this.updateVisibility();
            } else {
                $dispatch('open-modal', 'verify-pin');
            }
        },
        submitPin() {
            if (this.pin.length !== 4) {
                this.errorMessage = 'Please enter a 4-digit PIN.';
                return;
            }
            this.updateVisibility(this.pin);
        },
        updateVisibility(pin = null) {
            this.loading = true;
            this.errorMessage = '';
            
            fetch('{{ route('dashboard.toggle-balance-visibility') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ pin_code: pin })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.balanceVisible = data.balance_visibility;
                    if (this.balanceVisible) {
                        $dispatch('close-modal', 'verify-pin');
                        this.pin = '';
                    }
                } else {
                    this.errorMessage = data.message || 'Invalid PIN code.';
                }
            })
            .catch(error => {
                this.errorMessage = 'An error occurred. Please try again.';
                console.error('Error:', error);
            })
            .finally(() => {
                this.loading = false;
            });
        }
    }">
        <!-- Main Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Balance Card -->
            <div class="card-premium animate-fade-in-up" style="animation-delay: 0.1s;">
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-gold-premium-100 dark:bg-gold-premium-900/30 flex items-center justify-center text-gold-premium-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                        <div class="flex items-center gap-2">
                            <button @click="toggleBalance" class="p-2 rounded-xl hover:bg-vault-dark-100 dark:hover:bg-vault-dark-800 transition-colors text-vault-dark-400 hover:text-gold-premium-600" title="Toggle Balance Visibility">
                                <template x-if="balanceVisible">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </template>
                                <template x-if="!balanceVisible">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18" />
                                    </svg>
                                </template>
                            </button>
                            <span class="text-xs font-bold text-vault-dark-400 uppercase tracking-widest">Reserved</span>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-vault-dark-500 uppercase tracking-tight mb-1">Total Gold Balance
                    </p>
                    <div class="flex items-baseline gap-2">
                        <h3 class="text-3xl font-black text-vault-dark-900 dark:text-white" x-text="balanceVisible ? '{{ number_format(auth()->user()->gold_balance) }}' : '••••••'">
                            {{ auth()->user()->balance_visibility ? number_format(auth()->user()->gold_balance) : '••••••' }}
                        </h3>
                        <span class="text-lg font-bold text-gold-premium-600 lowercase">oz</span>
                    </div>
                </div>
            </div>

            <!-- Vault Capacity Card -->
            <div class="card-premium animate-fade-in-up" style="animation-delay: 0.2s;">
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                </path>
                            </svg>
                        </div>
                        @if(isset($showCapacityWarning) && $showCapacityWarning)
                            <span class="flex h-2 w-2 rounded-full bg-red-500 animate-ping"></span>
                        @endif
                    </div>
                    <p class="text-sm font-bold text-vault-dark-500 uppercase tracking-tight mb-2">Vault Utilization</p>

                    @if(isset($totalVaultCapacity) && $totalVaultCapacity > 0)
                        @php
                            $usage = (auth()->user()->gold_balance / $totalVaultCapacity) * 100;
                        @endphp
                        <div class="flex items-baseline gap-2 mb-3">
                            <h3 class="text-2xl font-black text-vault-dark-900 dark:text-white">
                                {{ number_format($usage, 1) }}%</h3>
                            <span class="text-sm font-bold text-vault-dark-400 uppercase tracking-widest">Used</span>
                        </div>
                        <div class="w-full bg-vault-dark-100 dark:bg-vault-dark-800 rounded-full h-2 overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full transition-all duration-1000 shadow-lg shadow-indigo-500/20"
                                style="width: {{ min(100, $usage) }}%"></div>
                        </div>
                        <p class="text-xs text-vault-dark-400 mt-2 italic">{{ $userVaultsCount ?? 0 }} assigned vaults</p>
                    @else
                        <h3 class="text-2xl font-black text-vault-dark-400">No Vault</h3>
                    @endif
                </div>
            </div>

            <!-- Documents Card -->
            <div class="card-premium animate-fade-in-up" style="animation-delay: 0.3s;">
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-vault-dark-500 uppercase tracking-tight mb-1">Stored Documents</p>
                    <h3 class="text-3xl font-black text-vault-dark-900 dark:text-white">{{ $totalDocuments }}</h3>
                    <p class="text-xs text-vault-dark-400 mt-auto pt-4">{{ $storageUsed }} consumed</p>
                </div>
            </div>

            <!-- Security Card -->
            <div class="card-premium animate-fade-in-up" style="animation-delay: 0.4s;">
                <div class="flex flex-col h-full">
                    <div class="flex items-center justify-between mb-6">
                        <div
                            class="w-12 h-12 rounded-2xl bg-amber-100 dark:bg-amber-900/30 flex items-center justify-center text-amber-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p class="text-sm font-bold text-vault-dark-500 uppercase tracking-tight mb-1">Last Access</p>
                    <h3 class="text-xl font-black text-vault-dark-900 dark:text-white mb-2">
                        {{ auth()->user()->last_login_at?->diffForHumans() ?? 'First session' }}</h3>
                    <div class="flex items-center gap-2 mt-auto">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                        <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">Secure
                            Connection</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            <!-- Recent Activity List -->
            <div class="lg:col-span-2 space-y-6">
                <div class="flex items-center justify-between mb-2 px-2 animate-fade-in-up">
                    <h3 class="text-2xl font-bold tracking-tight text-vault-dark-900 dark:text-white">Recent Documents
                    </h3>
                    <a href="{{ route('client.documents.index') }}"
                        class="text-sm font-bold text-gold-premium-600 hover:text-gold-premium-700 transition-colors uppercase tracking-widest">View
                        Archives</a>
                </div>

                <div class="glass flex flex-col rounded-3xl overflow-hidden border border-vault-dark-200/50 dark:border-vault-dark-800/50 animate-fade-in-up"
                    style="animation-delay: 0.5s;">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-vault-dark-50/50 dark:bg-vault-dark-900/50">
                                <tr>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-vault-dark-400 uppercase tracking-widest">
                                        Asset Details</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-vault-dark-400 uppercase tracking-widest">
                                        Classification</th>
                                    <th
                                        class="px-6 py-4 text-xs font-bold text-vault-dark-400 uppercase tracking-widest text-right">
                                        Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-vault-dark-100 dark:divide-vault-dark-800/50 px-6">
                                @forelse($recentDocuments as $document)
                                    <tr
                                        class="group hover:bg-gold-premium-50/10 dark:hover:bg-gold-premium-900/5 transition-colors duration-200">
                                        <td class="px-6 py-5">
                                            <div class="flex items-center gap-4">
                                                <div
                                                    class="w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-800 flex items-center justify-center text-vault-dark-400 group-hover:bg-gold-premium-100 dark:group-hover:bg-gold-premium-900 group-hover:text-gold-premium-600 transition-all duration-300">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <p class="text-sm font-bold text-vault-dark-900 dark:text-white mb-0.5">
                                                        {{ $document->name }}</p>
                                                    <p class="text-xs text-vault-dark-400 font-medium">Recorded
                                                        {{ $document->created_at->diffForHumans() }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-5">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest bg-vault-dark-100 dark:bg-vault-dark-800 text-vault-dark-500 border border-vault-dark-200 dark:border-vault-dark-700">
                                                {{ $document->type }} • {{ $document->size }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-5 text-right">
                                            <div
                                                class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                <a href="{{ route('client.documents.download', $document) }}"
                                                    class="p-2 rounded-lg bg-emerald-500/10 text-emerald-600 hover:bg-emerald-500 hover:text-white transition-all">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4">
                                                        </path>
                                                    </svg>
                                                </a>
                                                <form class="inline" method="POST"
                                                    action="{{ route('client.documents.destroy', $document) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="p-2 rounded-lg bg-red-500/10 text-red-600 hover:bg-red-500 hover:text-white transition-all"
                                                        onclick="return confirm('Securely erase this document from archives?')">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                            </path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-12 text-center">
                                            <div class="flex flex-col items-center">
                                                <div
                                                    class="w-16 h-16 rounded-full bg-vault-dark-100 dark:bg-vault-dark-800 flex items-center justify-center text-vault-dark-300 mb-4">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z">
                                                        </path>
                                                    </svg>
                                                </div>
                                                <h4 class="text-lg font-bold text-vault-dark-900 dark:text-white">Clean
                                                    Slate</h4>
                                                <p class="text-sm text-vault-dark-500 max-w-xs mt-1">Begin your digital
                                                    audit by uploading your first secure document.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Side Quick Actions -->
            <div class="space-y-6">
                <h3 class="text-2xl font-bold tracking-tight text-vault-dark-900 dark:text-white px-2 animate-fade-in-up"
                    style="animation-delay: 0.6s;">Protocol Shortcuts</h3>
                <div class="grid grid-cols-1 gap-4 animate-fade-in-up" style="animation-delay: 0.7s;">
                    <a href="{{ route('withdrawal-requests.create') }}"
                        class="card-premium group !p-4 border-none border-l-4 border-emerald-500">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-emerald-500 text-white flex items-center justify-center shadow-lg shadow-emerald-500/30 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="text-sm font-bold text-vault-dark-900 dark:text-white group-hover:text-emerald-600 transition-colors">
                                    Withdrawal Protocol</p>
                                <p class="text-xs text-vault-dark-500 font-medium">Initiate reserve liquidation</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('client.documents.create') }}"
                        class="card-premium group !p-4 border-none border-l-4 border-gold-premium-500">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-10 h-10 rounded-xl bg-gold-premium-500 text-white flex items-center justify-center shadow-lg shadow-gold-premium-500/30 transition-transform duration-300 group-hover:scale-110">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                            </div>
                            <div>
                                <p
                                    class="text-sm font-bold text-vault-dark-900 dark:text-white group-hover:text-gold-premium-600 transition-colors">
                                    Deposit Document</p>
                                <p class="text-xs text-vault-dark-500 font-medium">Verify asset records</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('client.profile') }}"
                        class="glass-premium p-4 rounded-3xl flex items-center gap-4 hover:bg-gold-premium-50/20 transition-all border border-vault-dark-100 dark:border-vault-dark-800">
                        <div
                            class="w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-800 text-vault-dark-500 flex items-center justify-center">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-bold text-vault-dark-900 dark:text-white">Security Settings</p>
                            <p class="text-xs text-vault-dark-500 font-medium">Configure access</p>
                        </div>
                    </a>

                    @if(auth()->user()->gold_balance > 0)
                        <div
                            class="glass-premium p-6 rounded-3xl border border-vault-dark-100 dark:border-vault-dark-800 bg-gradient-to-br from-vault-dark-50 to-vault-dark-100/50 dark:from-vault-dark-900 dark:to-vault-dark-800">
                            <div class="flex items-center gap-2 mb-4">
                                <span class="w-2 h-2 rounded-full bg-gold-premium-500 animate-pulse"></span>
                                <span class="text-[10px] font-black uppercase tracking-widest text-gold-premium-600">Active
                                    Reserves</span>
                            </div>
                            <p class="text-[10px] font-bold text-vault-dark-400 uppercase tracking-widest mb-1">Asset
                                Composition</p>
                            <p class="text-sm font-black text-vault-dark-900 dark:text-white">Physically Audited Bullion</p>
                            <div class="mt-4 pt-4 border-t border-vault-dark-200 dark:border-vault-dark-700">
                                <button
                                    class="w-full py-2 text-xs font-bold text-vault-dark-500 hover:text-gold-premium-600 transition-colors uppercase tracking-widest">Generate
                                    Audit Report</button>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- PIN Verification Modal -->
        <x-modal name="verify-pin" focusable>
            <div class="p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-2xl bg-gold-premium-100 dark:bg-gold-premium-900/30 flex items-center justify-center text-gold-premium-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-bold text-vault-dark-900 dark:text-white">
                            {{ __('Security Verification') }}
                        </h2>
                        <p class="text-sm text-vault-dark-500">
                            {{ __('Enter your 4-digit PIN to reveal your account balance.') }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <x-input-label for="pin_code" value="{{ __('Security PIN') }}" class="sr-only" />
                        <x-text-input id="pin_code" name="pin_code" type="password" 
                            class="mt-1 block w-full text-center text-2xl tracking-[1em] font-black focus:ring-gold-premium-500 focus:border-gold-premium-500" 
                            placeholder="••••" maxlength="4" x-model="pin" @keyup.enter="submitPin" autofocus />
                        
                        <div x-show="errorMessage" class="mt-3 p-3 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-800">
                            <p x-text="errorMessage" class="text-sm text-red-600 dark:text-red-400 font-bold"></p>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-2">
                        <x-secondary-button x-on:click="$dispatch('close')" class="!rounded-xl">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button @click="submitPin" ::disabled="loading" class="!rounded-xl bg-gold-premium-600 hover:bg-gold-premium-700">
                            <span x-show="!loading">{{ __('Verify & Reveal') }}</span>
                            <span x-show="loading" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                {{ __('Verifying...') }}
                            </span>
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </x-modal>
    </div>

</x-client-layout>