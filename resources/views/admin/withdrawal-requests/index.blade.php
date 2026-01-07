<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
                    Asset <span class="text-emerald-500">Exfiltration</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-vault-dark-400 mt-2">Withdrawal
                    Authorization & Processing Ledger</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        <!-- Filters -->
        <div class="flex flex-wrap gap-4">
            <a href="{{ route('admin.withdrawal-requests.index', ['status' => 'pending']) }}"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all
               {{ request('status') === 'pending' ? 'bg-gold-premium-500 text-white shadow-lg shadow-gold-premium-500/20' : 'glass text-vault-dark-600 hover:bg-gold-premium-500/10' }}">
                Pending Protocol ({{ $pendingCount }})
            </a>
            <a href="{{ route('admin.withdrawal-requests.index', ['status' => 'approved']) }}"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all
               {{ request('status') === 'approved' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/20' : 'glass text-vault-dark-600 hover:bg-emerald-500/10' }}">
                Authorized ({{ $approvedCount }})
            </a>
            <a href="{{ route('admin.withdrawal-requests.index', ['status' => 'rejected']) }}"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all
               {{ request('status') === 'rejected' ? 'bg-red-500 text-white shadow-lg shadow-red-500/20' : 'glass text-vault-dark-600 hover:bg-red-500/10' }}">
                Terminated ({{ $rejectedCount }})
            </a>
            <a href="{{ route('admin.withdrawal-requests.index') }}"
                class="px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest transition-all
               {{ !request('status') ? 'bg-vault-dark-900 text-white shadow-lg shadow-vault-dark-900/20' : 'glass text-vault-dark-600 hover:bg-vault-dark-100' }}">
                Entire Stream
            </a>
        </div>

        <!-- Requests Matrix -->
        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                    <thead class="bg-vault-dark-100/30 dark:bg-vault-dark-900/30">
                        <tr>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Entity Node</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Reserve Quantity</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Objective</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Status</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Synchronized</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Authorization</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                        @forelse($withdrawalRequests as $request)
                            <tr class="group hover:bg-gold-premium-50/30 dark:hover:bg-gold-premium-900/5 transition-all">
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-900 flex items-center justify-center text-xs font-black text-vault-dark-600 group-hover:bg-gold-premium-600 group-hover:text-white transition-all">
                                            {{ substr($request->user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <div
                                                class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                                {{ $request->user->name }}
                                            </div>
                                            <div class="text-[10px] text-vault-dark-400 uppercase font-bold">
                                                {{ $request->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <div class="text-sm font-black text-vault-dark-900 dark:text-white">
                                        {{ number_format($request->amount, 2) }} <span
                                            class="text-[10px] text-gold-premium-600">OZ</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6">
                                    <div
                                        class="text-xs font-bold text-vault-dark-500 uppercase leading-relaxed max-w-xs truncate">
                                        {{ $request->purpose ?? 'UNDOCUMENTED OBJECTIVE' }}
                                    </div>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    <span class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                                                @if($request->status === 'pending') bg-yellow-500/10 text-yellow-600
                                                @elseif($request->status === 'approved') bg-emerald-500/10 text-emerald-600
                                                @else bg-red-500/10 text-red-600 @endif">
                                        {{ $request->status }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap text-[10px] font-bold text-vault-dark-400 uppercase">
                                    {{ $request->created_at->format('M d, Y H:i') }}
                                </td>
                                <td class="px-8 py-6 whitespace-nowrap">
                                    @if($request->status === 'pending')
                                        <div class="flex flex-col gap-3 min-w-[200px]">
                                            <form action="{{ route('admin.withdrawal-requests.update', $request) }}"
                                                method="POST" class="flex flex-col gap-2">
                                                @csrf
                                                @method('PUT')
                                                <input type="text" name="admin_notes"
                                                    class="text-[10px] w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-lg focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all py-1.5 px-3 font-bold text-vault-dark-900 dark:text-white placeholder-vault-dark-300"
                                                    placeholder="Add protocol notes...">

                                                <div class="flex items-center gap-2">
                                                    <button type="submit" name="status" value="approved"
                                                        class="flex-1 px-3 py-2 bg-emerald-500/10 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-emerald-500 hover:text-white transition-all"
                                                        onclick="return confirm('Authorize asset exfiltration for this entity?')">
                                                        Authorize
                                                    </button>
                                                    <button type="submit" name="status" value="rejected"
                                                        class="flex-1 px-3 py-2 bg-red-500/10 text-red-600 text-[10px] font-black uppercase tracking-widest rounded-xl hover:bg-red-500 hover:text-white transition-all"
                                                        onclick="return confirm('Terminate this exfiltration protocol?')">
                                                        Terminate
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    @else
                                        <div class="flex flex-col">
                                            <span
                                                class="text-[10px] font-black text-vault-dark-300 uppercase italic tracking-widest">Protocol
                                                Finalized</span>
                                            @if($request->admin_notes)
                                                <span
                                                    class="text-[9px] text-vault-dark-400 font-bold uppercase mt-1 truncate max-w-[150px]"
                                                    title="{{ $request->admin_notes }}">
                                                    Note: {{ $request->admin_notes }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-vault-dark-50 dark:bg-vault-dark-900/50 flex items-center justify-center mb-4">
                                            <svg class="w-6 h-6 text-vault-dark-200" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-3.586a1 1 0 00-.707.293l-1.414 1.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-1.414-1.414A1 1 0 006.586 13H2" />
                                            </svg>
                                        </div>
                                        <p class="text-xs font-black text-vault-dark-400 uppercase tracking-widest">No
                                            Stream Data Detected</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Matrix Pagination -->
        @if($withdrawalRequests->hasPages())
            <div class="mt-8 glass p-4 rounded-3xl">
                {{ $withdrawalRequests->links() }}
            </div>
        @endif
    </div>
</x-admin-layout>