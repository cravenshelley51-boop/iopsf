<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
                    Personnel <span class="text-gold-premium-600">Intelligence</span>
                </h2>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-[0.3em] font-black">Strategic Data Matrix
                </p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-12">
        <!-- Stats Overview -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            <div class="card-premium p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl bg-blue-500/10">
                        <svg class="w-6 h-6 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Registry Total
                        </p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl bg-emerald-500/10">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500">Active Protocols
                        </p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">{{ $activeUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl bg-gold-premium-500/10">
                        <svg class="w-6 h-6 text-gold-premium-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-gold-premium-500">Recent Influx
                        </p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">{{ $newUsers }}</p>
                    </div>
                </div>
            </div>

            <div class="card-premium p-6">
                <div class="flex items-center gap-4">
                    <div class="p-3 rounded-2xl bg-purple-500/10">
                        <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-widest text-purple-500">Engage Metric</p>
                        <p class="text-2xl font-black text-vault-dark-900 dark:text-white">{{ $avgSessionTime }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- User Growth Chart -->
            <div class="lg:col-span-2 card-premium p-8">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-vault-dark-500">Personnel Influx Stream
                    </h3>
                    <div class="flex gap-2">
                        <div class="w-2 h-2 rounded-full bg-blue-500 animate-pulse"></div>
                    </div>
                </div>
                <div class="h-80 relative">
                    <canvas id="userGrowthChart"></canvas>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card-premium p-8 h-full flex flex-col">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-sm font-black uppercase tracking-widest text-vault-dark-500">Activity Ledger</h3>
                    <svg class="w-4 h-4 text-vault-dark-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="space-y-6 flex-1 overflow-y-auto pr-2 custom-scrollbar">
                    @forelse($recentActivities as $activity)
                        <div class="flex items-start gap-4 group">
                            <div
                                class="flex-shrink-0 w-1 y-10 bg-vault-dark-100 dark:bg-vault-dark-800 rounded-full group-hover:bg-gold-premium-500 transition-colors mt-1">
                            </div>
                            <div class="flex-1">
                                <p
                                    class="text-xs font-bold text-vault-dark-900 dark:text-white group-hover:text-gold-premium-600 transition-colors">
                                    {{ $activity->description }}</p>
                                <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter">
                                    {{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-12 text-center">
                            <div
                                class="w-12 h-12 rounded-full bg-vault-dark-100 dark:bg-vault-dark-800 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-vault-dark-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 006.586 13H2" />
                                </svg>
                            </div>
                            <p class="text-xs font-bold text-vault-dark-500 uppercase tracking-widest">No Recent Telemetry
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('userGrowthChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($growthLabels),
                    datasets: [{
                        label: 'Matrix Entries',
                        data: @json($growthData),
                        borderColor: '#D4AF37',
                        backgroundColor: 'rgba(212, 175, 55, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointBackgroundColor: '#D4AF37',
                        pointBorderColor: '#fff',
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(212, 175, 55, 0.05)' },
                            ticks: { font: { size: 10, weight: 'bold' } }
                        },
                        x: {
                            grid: { display: false },
                            ticks: { font: { size: 10, weight: 'bold' } }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-admin-layout>