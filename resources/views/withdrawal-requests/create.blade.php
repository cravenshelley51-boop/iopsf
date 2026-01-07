<x-client-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2
                    class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase leading-none">
                    Initiate <span class="text-gold-premium-600">Outflux</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-vault-dark-400 mt-2">Reserve
                    Liquidation Protocol</p>
            </div>
            <a href="{{ route('withdrawal-requests.my') }}"
                class="glass px-6 py-3 rounded-2xl flex items-center gap-3 group transition-all hover:border-gold-premium-500/30">
                <svg class="w-4 h-4 text-vault-dark-600 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-700">Abort Mission</span>
            </a>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto pb-12">
        <div class="card-premium p-8 md:p-12 overflow-hidden relative">
            <!-- Background Decoration -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gold-premium-500/5 rounded-full blur-3xl -mr-32 -mt-32">
            </div>

            <div class="relative z-10">
                <!-- Reserve Status Card -->
                <div class="glass p-6 rounded-3xl mb-12 border-gold-premium-500/10">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 rounded-2xl bg-gold-premium-500/10 flex items-center justify-center text-gold-premium-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-vault-dark-400 uppercase tracking-widest">
                                    Available Reserves</p>
                                <p class="text-2xl font-black text-vault-dark-900 dark:text-white mt-1"
                                    id="balance-display">
                                    @if(auth()->user()->balance_visibility)
                                        {{ number_format(auth()->user()->gold_balance, 2) }} <span
                                            class="text-sm text-gold-premium-600 uppercase">OZ</span>
                                    @else
                                        <span class="tracking-[0.5em]">••••</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <button type="button" onclick="toggleBalanceVisibility()"
                            class="p-3 glass rounded-xl text-vault-dark-400 hover:text-gold-premium-600 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <form action="{{ route('withdrawal-requests.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <label for="amount"
                            class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-3">Liquidation
                            Quantum (Amount)</label>
                        <div class="relative group">
                            <input type="number" name="amount" id="amount" step="0.01" min="0.01"
                                max="{{ auth()->user()->balance_visibility ? auth()->user()->gold_balance : '999999' }}"
                                class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4 pl-6 pr-16 font-black text-vault-dark-900 dark:text-white placeholder-vault-dark-300"
                                placeholder="0.00" required>
                            <div class="absolute inset-y-0 right-0 pr-6 flex items-center pointer-events-none">
                                <span
                                    class="text-[10px] font-black text-gold-premium-600 uppercase tracking-widest">OZ</span>
                            </div>
                        </div>
                        <p class="mt-3 text-[10px] text-vault-dark-400 font-bold uppercase tracking-tighter">Specify the
                            exact volume of gold to be processed for outflux.</p>
                    </div>

                    <div>
                        <label for="purpose"
                            class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-3">Operational
                            Directive (Purpose)</label>
                        <textarea name="purpose" id="purpose" rows="4"
                            class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4 px-6 font-bold text-vault-dark-900 dark:text-white placeholder-vault-dark-300 leading-relaxed"
                            placeholder="Document the purpose of this liquidation request (optional)..."></textarea>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <a href="{{ route('withdrawal-requests.my') }}"
                            class="flex-1 glass py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-vault-dark-100 transition-all">
                            Discard
                        </a>
                        <button type="submit"
                            class="flex-[2] bg-gold-premium-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gold-premium-700 shadow-xl shadow-gold-premium-600/20 transition-all">
                            Transmit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Security PIN Verification Backdrop -->
    <div id="pin-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6 sm:p-0">
        <div class="absolute inset-0 bg-vault-dark-950/80 backdrop-blur-sm" onclick="hidePinModal()"></div>
        <div class="relative w-full max-w-md card-premium p-8 overflow-hidden animate-fade-in-up">
            <div class="absolute top-0 right-0 w-32 h-32 bg-gold-premium-500/5 rounded-full blur-3xl -mr-16 -mt-16">
            </div>

            <div class="flex justify-between items-center mb-8 relative z-10">
                <div>
                    <h3 class="text-xl font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">Access
                        Authorization</h3>
                    <p class="text-[10px] text-gold-premium-600 uppercase tracking-widest font-black mt-1">Identity
                        Verification Required</p>
                </div>
                <button onclick="hidePinModal()"
                    class="text-vault-dark-300 hover:text-vault-dark-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="space-y-6 relative z-10">
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-vault-dark-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" id="pin-input"
                        class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4 pl-12 tracking-[1em] placeholder:tracking-normal placeholder:text-vault-dark-300"
                        maxlength="4" pattern="[0-9]{4}" placeholder="••••">
                </div>
                <p id="pin-error" class="text-[10px] font-black text-red-600 uppercase tracking-widest hidden"></p>

                <div class="flex gap-4">
                    <button type="button" onclick="hidePinModal()"
                        class="flex-1 glass py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-vault-dark-100 transition-all">
                        Abort
                    </button>
                    <button type="button" onclick="verifyPin()"
                        class="flex-2 bg-gold-premium-600 text-white py-4 px-8 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gold-premium-700 shadow-xl shadow-gold-premium-600/20 transition-all">
                        Finalize Access
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let balanceVisibility = @json(auth()->user()->balance_visibility);
        const currentBalance = {{ auth()->user()->gold_balance }};

        function toggleBalanceVisibility() {
            if (!balanceVisibility) {
                document.getElementById('pin-modal').classList.remove('hidden');
                document.getElementById('pin-input').value = '';
                document.getElementById('pin-error').classList.add('hidden');
            } else {
                fetch('{{ route("dashboard.toggle-balance-visibility") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            balanceVisibility = data.balance_visibility;
                            updateBalanceVisibility(data.balance_visibility);
                        }
                    });
            }
        }

        function hidePinModal() {
            document.getElementById('pin-modal').classList.add('hidden');
        }

        function verifyPin() {
            const pin = document.getElementById('pin-input').value;

            fetch('{{ route("dashboard.toggle-balance-visibility") }}', {
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
                        hidePinModal();
                        balanceVisibility = data.balance_visibility;
                        updateBalanceVisibility(data.balance_visibility);
                    } else {
                        document.getElementById('pin-error').textContent = data.message;
                        document.getElementById('pin-error').classList.remove('hidden');
                    }
                });
        }

        function updateBalanceVisibility(visible) {
            const balanceDisplay = document.getElementById('balance-display');
            if (visible) {
                balanceDisplay.innerHTML = currentBalance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + ' <span class="text-sm text-gold-premium-600 uppercase">OZ</span>';
            } else {
                balanceDisplay.innerHTML = '<span class="tracking-[0.5em]">••••</span>';
            }

            const amountInput = document.getElementById('amount');
            if (visible) {
                amountInput.max = currentBalance;
            } else {
                amountInput.max = '999999';
            }
        }
    </script>
</x-client-layout>