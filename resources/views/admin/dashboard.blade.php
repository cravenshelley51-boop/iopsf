<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2
                    class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase leading-none">
                    Security <span class="text-gold-premium-600">Headquarters</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-vault-dark-400 mt-2">Strategic Command
                    & Control Center</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.withdrawal-requests.index') }}"
                    class="glass px-6 py-3 rounded-2xl flex items-center gap-3 group transition-all">
                    <div class="relative">
                        <span class="absolute -top-1 -right-1 w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                        <svg class="w-4 h-4 text-vault-dark-600 group-hover:text-red-500 transition-colors" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-700">Pending Actions:
                        {{ $pendingWithdrawals }}</span>
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn-premium px-8 py-3">
                    {{ __('Deploy New Identity') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-12 pb-12">
        <!-- Strategic Metrics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <a href="{{ route('admin.users.index') }}" class="card-premium p-6 group block transition-all hover:bg-gold-premium-50/10 active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-blue-500/10 flex items-center justify-center text-blue-600 group-hover:bg-blue-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Total Entities
                        </p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">
                            {{ number_format($totalUsers) }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-[10px] font-black text-emerald-500 uppercase">+{{ $newUsers }} NEW</span>
                    <span class="text-[10px] text-vault-dark-400 uppercase tracking-tighter">THIS CYCLE</span>
                </div>
            </a>

            <a href="{{ route('admin.users.overview') }}" class="card-premium p-6 group block transition-all hover:bg-emerald-50/10 active:scale-[0.98]">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center text-emerald-500 group-hover:bg-emerald-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                        </svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Online Nodes</p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">
                            {{ number_format($activeUsers) }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span class="text-[10px] font-black text-emerald-600 uppercase">Live Flux</span>
                </div>
            </a>

            <div class="card-premium p-6 group">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-gold-premium-500/10 flex items-center justify-center text-gold-premium-600 group-hover:bg-gold-premium-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                        </svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest text-gold-premium-500">Vaulted
                            Reserve</p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white truncate">
                            {{ number_format($totalGoldBalance, 2) }} <span class="text-xs">OZ</span></p>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-[10px] font-black text-vault-dark-400 uppercase tracking-tighter">TOTAL APPRAISED
                        VALUE</span>
                </div>
            </div>

            <div class="card-premium p-6 group">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-red-500/10 flex items-center justify-center text-red-500 group-hover:bg-red-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest text-red-500">Withdrawal Alert</p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">
                            {{ number_format($pendingWithdrawals) }}</p>
                    </div>
                </div>
                <div class="mt-4 flex items-center gap-2">
                    <span class="text-[10px] font-black text-red-600 uppercase tracking-widest">ATTENTION
                        REQUIRED</span>
                </div>
            </div>

            <div class="card-premium p-6 group border-purple-500/20">
                <div class="flex items-center gap-4">
                    <div
                        class="w-12 h-12 rounded-2xl bg-purple-500/10 flex items-center justify-center text-purple-600 group-hover:bg-purple-500 group-hover:text-white transition-all duration-500">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                        </svg>
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-[10px] font-black uppercase tracking-widest text-purple-500">System Capacity</p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">
                            {{ number_format($availableVaults) }} / {{ number_format($totalVaults) }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full bg-vault-dark-100 dark:bg-vault-dark-800 h-1 rounded-full overflow-hidden">
                        <div class="bg-purple-500 h-full rounded-full"
                            style="width: {{ ($totalVaults > 0) ? ($assignedVaults / $totalVaults * 100) : 0 }}%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Systems Feed (Recent Activity) -->
            <div class="card-premium p-8 overflow-hidden flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-gold-premium-600 rounded-full"></div>
                        <h3 class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500">Intelligence
                            Stream</h3>
                    </div>
                    <a href="{{ route('admin.users.index') }}"
                        class="text-[10px] font-black uppercase tracking-widest text-gold-premium-600 hover:text-gold-premium-500 transition-colors">Access
                        Personnel Matrix</a>
                </div>

                <div class="space-y-6 flex-1 pr-2 custom-scrollbar">
                    @forelse($recentActivities as $activity)
                        <div
                            class="flex items-start gap-4 p-4 rounded-2xl glass border border-transparent hover:border-gold-premium-500/20 transition-all duration-300 group">
                            <div
                                class="flex-shrink-0 w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-900 flex items-center justify-center text-gold-premium-600 font-bold group-hover:bg-gold-premium-600 group-hover:text-white transition-all">
                                {{ substr($activity->user->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-xs font-black text-vault-dark-900 dark:text-white uppercase tracking-tight group-hover:text-gold-premium-600 transition-colors">
                                    {{ $activity->description }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span
                                        class="text-[10px] font-bold text-vault-dark-500">{{ $activity->user->name }}</span>
                                    <span
                                        class="text-[10px] text-vault-dark-300 uppercase tracking-tighter">{{ $activity->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <div
                                class="w-16 h-16 rounded-3xl bg-vault-dark-50 dark:bg-vault-dark-900 flex items-center justify-center mb-6">
                                <svg class="w-8 h-8 text-vault-dark-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <p class="text-xs font-black text-vault-dark-500 uppercase tracking-widest">No Active Telemetry
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Financial Flux (Recent Withdrawals) -->
            <div class="card-premium p-8 overflow-hidden flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <div class="flex items-center gap-3">
                        <div class="w-1.5 h-6 bg-emerald-500 rounded-full"></div>
                        <h3 class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500">Asset Liquidations
                        </h3>
                    </div>
                    <a href="{{ route('admin.withdrawal-requests.index') }}"
                        class="text-[10px] font-black uppercase tracking-widest text-emerald-600 hover:text-emerald-500 transition-colors">Authorize
                        Transfers</a>
                </div>

                <div class="space-y-4 flex-1 pr-2 custom-scrollbar">
                    @forelse($recentWithdrawals as $withdrawal)
                        <div
                            class="p-5 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800 flex items-center justify-between group hover:border-emerald-500/30 transition-all duration-300">
                            <div class="flex items-center gap-4">
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 transition-colors group-hover:bg-emerald-500 group-hover:text-white">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">
                                        {{ $withdrawal->user->name }}</p>
                                    <p class="text-[10px] text-vault-dark-400 mt-0.5 uppercase tracking-tighter">
                                        {{ $withdrawal->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-vault-dark-900 dark:text-white">
                                    {{ number_format($withdrawal->amount, 2) }} <span class="text-[10px]">OZ</span></p>
                                <span class="mt-1 inline-flex px-2 py-0.5 rounded-full text-[8px] font-black uppercase tracking-widest
                                        @if($withdrawal->status === 'pending') bg-yellow-500/10 text-yellow-600
                                        @elseif($withdrawal->status === 'approved') bg-emerald-500/10 text-emerald-600
                                        @else bg-red-500/10 text-red-600 @endif">
                                    {{ $withdrawal->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-24 text-center">
                            <svg class="w-12 h-12 text-vault-dark-200 mb-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-xs font-black text-vault-dark-500 uppercase tracking-widest">No Recent
                                Liquidations</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Strategic Actions Matrix -->
        <div class="card-premium p-8">
            <h3 class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500 mb-8">Protocol Actions Matrix
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.users.create') }}"
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 hover:border-gold-premium-500/40 hover:-translate-y-1 transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-600 mb-4 group-hover:bg-blue-500 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">Deploy Identity</p>
                    <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Initialize new
                        client profile</p>
                </a>

                <a href="{{ route('admin.users.overview') }}"
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 hover:border-purple-500/40 hover:-translate-y-1 transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center text-purple-600 mb-4 group-hover:bg-purple-500 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">Personnel Intelligence</p>
                    <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Strategic matrix 
                        analytics</p>
                </a>

                <a href="{{ route('admin.withdrawal-requests.index') }}"
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 hover:border-emerald-500/40 hover:-translate-y-1 transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-600 mb-4 group-hover:bg-emerald-500 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">Process Transfers</p>
                    <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Authorize asset
                        movement</p>
                </a>

                <a href="{{ route('admin.documents.index') }}"
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 hover:border-gold-premium-500/40 hover:-translate-y-1 transition-all group">
                    <div
                        class="w-10 h-10 rounded-xl bg-gold-premium-500/10 flex items-center justify-center text-gold-premium-600 mb-4 group-hover:bg-gold-premium-500 group-hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <p class="text-xs font-black text-vault-dark-900 dark:text-white uppercase">Vault Auditing</p>
                    <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Verify document
                        integrity</p>
                </a>
            </div>
        </div>
    </div>
</x-admin-layout>