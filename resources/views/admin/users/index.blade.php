<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
                    Identity <span class="text-gold-premium-600">Matrix</span>
                </h2>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-[0.3em] font-black">Authorized Personnel
                    Directory</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <form action="{{ route('admin.users.assign-vault-to-all') }}" method="POST"
                    onsubmit="return confirm('Assign a vault to all clients without one? This uses available vaults.')">
                    @csrf
                    <button type="submit"
                        class="glass px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest text-vault-dark-700 hover:text-gold-premium-600 transition-all">
                        {{ __('Mass Vault Deployment') }}
                    </button>
                </form>
                <a href="{{ route('admin.users.create') }}" class="btn-premium px-8 py-3">
                    {{ __('Onboard Entity') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-12">
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="card-premium p-8">
                <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400 mb-2">Total Verified
                    Users</p>
                <div class="flex items-end justify-between">
                    <span
                        class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white">{{ $totalUsers }}</span>
                    <div class="w-12 h-12 rounded-2xl bg-gold-premium-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gold-premium-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-premium p-8">
                <p class="text-[10px] font-black uppercase tracking-widest text-emerald-500 mb-2">Active Protocols</p>
                <div class="flex items-end justify-between">
                    <span
                        class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white">{{ $activeSessions }}</span>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="card-premium p-8">
                <p class="text-[10px] font-black uppercase tracking-widest text-gold-premium-500 mb-2">Storage
                    Utilization</p>
                <div class="flex items-end justify-between">
                    <span
                        class="text-4xl font-black tracking-tighter text-vault-dark-900 dark:text-white">{{ $storageUsed }}</span>
                    <div class="w-12 h-12 rounded-2xl bg-gold-premium-500/10 flex items-center justify-center">
                        <svg class="w-6 h-6 text-gold-premium-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Personnel Table -->
        <div class="card-premium overflow-hidden">
            <div
                class="px-8 py-6 border-b border-vault-dark-100 dark:border-vault-dark-800 bg-vault-dark-50/50 dark:bg-vault-dark-900/50 flex items-center justify-between">
                <h3 class="text-sm font-black uppercase tracking-widest text-vault-dark-500">Personnel Roster</h3>
                <div class="flex gap-2">
                    <div class="w-2 h-2 rounded-full bg-emerald-500"></div>
                    <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400">Real-time
                        Stream</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-vault-dark-100/30 dark:bg-vault-dark-900/30">
                            <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-vault-dark-400">
                                Identified User</th>
                            <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-vault-dark-400">
                                Protocol Entry</th>
                            <th class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-vault-dark-400">
                                Reserve Allocation</th>
                            <th
                                class="px-8 py-4 text-[10px] font-black uppercase tracking-widest text-vault-dark-400 text-right">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                        @foreach($users as $user)
                            <tr class="group hover:bg-gold-premium-50/30 dark:hover:bg-gold-premium-900/5 transition-all">
                                <td class="px-8 py-6">
                                    <div class="flex items-center">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-vault-dark-200 dark:bg-vault-dark-800 flex items-center justify-center font-black text-vault-dark-500 group-hover:bg-gold-premium-500 group-hover:text-white transition-all">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <p class="text-sm font-bold text-vault-dark-900 dark:text-white">
                                                {{ $user->name }}
                                            </p>
                                            <p class="text-xs text-vault-dark-400">{{ $user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex flex-col">
                                        <span
                                            class="text-xs font-bold text-vault-dark-700 dark:text-vault-dark-300">{{ $user->created_at->format('M d, Y') }}</span>
                                        <span
                                            class="text-[10px] text-vault-dark-400 uppercase tracking-tighter">{{ $user->created_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="w-2 h-2 rounded-full {{ $user->vaults_count > 0 ? 'bg-gold-premium-500' : 'bg-red-500' }}">
                                        </div>
                                        <span
                                            class="text-sm font-black text-vault-dark-900 dark:text-white">{{ number_format($user->gold_balance ?? 0, 2) }}</span>
                                        <span class="text-[10px] font-black text-vault-dark-400">GRM</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-emerald-500 transition-all"
                                            title="View Intel">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.show', $user) }}"
                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-purple-500 transition-all"
                                            title="Vault Management">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                            </svg>
                                        </a>
                                        {{-- <a href="{{ route('admin.documents.request', $user) }}"
                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-blue-500 transition-all"
                                            title="Request Documentation">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </a> --}}
                                        <a href="{{ route('admin.users.edit', $user) }}"
                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-gold-premium-600 transition-all"
                                            title="Edit Entity">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('admin.users.deposit', $user) }}"
                                            class="p-2 glass rounded-xl text-vault-dark-400 hover:text-emerald-500 transition-all"
                                            title="Initialize Deposit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                            </svg>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 glass rounded-xl text-vault-dark-400 hover:text-red-500 transition-all"
                                                onclick="return confirm('Archive entity profile? This action is irreversible.')"
                                                title="Terminate Profile">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div
                    class="px-8 py-6 bg-vault-dark-50/50 dark:bg-vault-dark-900/50 border-t border-vault-dark-100 dark:border-vault-dark-800 font-bold">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>