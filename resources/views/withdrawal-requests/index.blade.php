<x-client-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2
                    class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase leading-none">
                    Asset <span class="text-gold-premium-600">Liquidations</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-vault-dark-400 mt-2">Withdrawal
                    Authorization & Reserve Management</p>
            </div>
            <div class="flex items-center gap-4">
                <button onclick="toggleBalanceVisibility()"
                    class="glass px-6 py-3 rounded-2xl flex items-center gap-3 transition-all hover:border-gold-premium-500/30">
                    <svg class="w-4 h-4 text-vault-dark-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-700">Toggle
                        Intel</span>
                </button>
                <a href="{{ route('withdrawal-requests.create') }}" class="btn-premium px-8 py-3">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Initiate Outflux
                    </span>
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-12 pb-12">
        <!-- Quick Stats Matrix -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-premium p-8 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-gold-premium-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-gold-premium-500/10 transition-all">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400 mb-4">Available
                        Reserves</p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white"
                            id="balance-display">
                            @if(auth()->user()->balance_visibility)
                                {{ number_format(auth()->user()->gold_balance, 2) }} <span
                                    class="text-lg text-gold-premium-600">OZ</span>
                            @else
                                <span class="tracking-[0.5em]">••••</span>
                            @endif
                        </span>
                        <div
                            class="w-12 h-12 rounded-2xl bg-gold-premium-500/10 flex items-center justify-center text-gold-premium-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-premium p-8 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-blue-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-blue-500/10 transition-all">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400 mb-4">Pending
                        Authorization</p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white">
                            {{ $pendingWithdrawals }}
                        </span>
                        <div
                            class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-premium p-8 relative overflow-hidden group">
                <div
                    class="absolute top-0 right-0 w-32 h-32 bg-emerald-500/5 rounded-full blur-3xl -mr-16 -mt-16 group-hover:bg-emerald-500/10 transition-all">
                </div>
                <div class="relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400 mb-4">Authorized
                        Outflux</p>
                    <div class="flex items-end justify-between">
                        <span class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white"
                            id="total-withdrawn">
                            @if(auth()->user()->balance_visibility)
                                {{ number_format($totalWithdrawn, 2) }} <span class="text-lg text-emerald-600">OZ</span>
                            @else
                                <span class="tracking-[0.5em]">••••</span>
                            @endif
                        </span>
                        <div
                            class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Liquidation Ledger -->
        <div class="card-premium overflow-hidden">
            <div
                class="px-8 py-6 border-b border-vault-dark-100 dark:border-vault-dark-800 bg-vault-dark-50/30 dark:bg-vault-dark-900/30 flex items-center justify-between">
                <div>
                    <h3 class="text-sm font-black uppercase tracking-widest text-vault-dark-500">Liquidation Ledger</h3>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="glass px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-vault-dark-400 hover:text-vault-dark-900">Filter</button>
                    <button
                        class="glass px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest text-vault-dark-400 hover:text-vault-dark-900">Export</button>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                    <thead class="bg-vault-dark-50/50 dark:bg-vault-dark-950/50">
                        <tr>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Entry Date</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Quantum Amount</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Objective</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Auth Status</th>
                            <th
                                class="px-8 py-5 text-right text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Protocols</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                        @forelse($withdrawalRequests as $request)
                                            <tr class="group hover:bg-gold-premium-50/30 dark:hover:bg-gold-premium-900/5 transition-all">
                                                <td class="px-8 py-6 whitespace-nowrap">
                                                    <div class="flex flex-col">
                                                        <span
                                                            class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">{{ $request->created_at->format('M d, Y') }}</span>
                                                        <span
                                                            class="text-[10px] text-vault-dark-400 uppercase font-black tracking-widest">{{ $request->created_at->format('H:i') }}</span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap">
                                                    <div class="flex items-center gap-2">
                                                        <span
                                                            class="text-sm font-black py-1 px-2 rounded-lg bg-vault-dark-100 dark:bg-vault-dark-900 text-vault-dark-900 dark:text-white"
                                                            id="amount-{{ $request->id }}">
                                                            @if(auth()->user()->balance_visibility)
                                                                {{ number_format($request->amount, 2) }} <span
                                                                    class="text-[10px] text-gold-premium-600">OZ</span>
                                                            @else
                                                                <span class="tracking-widest">••••</span>
                                                            @endif
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-6">
                                                    <span
                                                        class="text-xs font-bold text-vault-dark-600 dark:text-vault-dark-400 uppercase tracking-widest">{{ $request->purpose ?: 'General Liquidation' }}</span>
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap">
                                                    <span
                                                        class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                                                                                {{ $request->status === 'pending' ? 'bg-yellow-500/10 text-yellow-600' :
                            ($request->status === 'approved' ? 'bg-emerald-500/10 text-emerald-600' : 'bg-red-500/10 text-red-600') }}">
                                                        {{ $request->status }}
                                                    </span>
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap text-right">
                                                    @if($request->status === 'pending')
                                                        <form action="{{ route('withdrawal-requests.cancel', $request) }}" method="POST"
                                                            class="inline" onsubmit="return confirm('Abort this liquidation request?')">
                                                            @csrf
                                                            <button type="submit"
                                                                class="p-2 glass rounded-xl text-red-400 hover:text-red-900 dark:hover:text-red-300 transition-all"
                                                                title="Abort Request">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                        d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <button
                                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-vault-dark-900 dark:hover:text-white transition-all">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                                            </svg>
                                                        </button>
                                                    @endif
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-16 h-16 rounded-3xl bg-vault-dark-50 dark:bg-vault-dark-950/50 flex items-center justify-center mb-6">
                                            <svg class="w-8 h-8 text-vault-dark-200" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-xs font-black text-vault-dark-500 uppercase tracking-widest">No
                                            Outflux History Detected</p>
                                        <p class="text-[10px] text-vault-dark-400 mt-2 font-bold uppercase">Initiate your
                                            first liquidation request at your convenience.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($withdrawalRequests->hasPages())
                <div
                    class="px-8 py-6 bg-vault-dark-50/50 dark:bg-vault-dark-900/50 border-t border-vault-dark-100 dark:border-vault-dark-800">
                    {{ $withdrawalRequests->links() }}
                </div>
            @endif
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
        const totalWithdrawn = {{ $totalWithdrawn }};

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
                balanceDisplay.innerHTML = currentBalance.toLocaleString(undefined, { minimumFractionDigits: 2 }) + ' <span class="text-lg text-gold-premium-600">OZ</span>';
            } else {
                balanceDisplay.innerHTML = '<span class="tracking-[0.5em]">••••</span>';
            }

            const totalWithdrawnDisplay = document.getElementById('total-withdrawn');
            if (visible) {
                totalWithdrawnDisplay.innerHTML = totalWithdrawn.toLocaleString(undefined, { minimumFractionDigits: 2 }) + ' <span class="text-lg text-emerald-600">OZ</span>';
            } else {
                totalWithdrawnDisplay.innerHTML = '<span class="tracking-[0.5em]">••••</span>';
            }

            @foreach($withdrawalRequests as $request)
                const amountCell{{ $request->id }} = document.getElementById('amount-{{ $request->id }}');
                if (amountCell{{ $request->id }}) {
                    amountCell{{ $request->id }}.innerHTML = visible ? '{{ number_format($request->amount, 2) }} <span class="text-[10px] text-gold-premium-600">OZ</span>' : '<span class="tracking-widest">••••</span>';
                }
            @endforeach
        }
    </script>
</x-client-layout>