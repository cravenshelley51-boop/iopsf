<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2 class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
                    Document <span class="text-gold-premium-600">Verification</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-vault-dark-400 mt-2">Intelligence
                    Authentication & Compliance Protocol</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        @if(session('success'))
            <div class="p-4 glass border border-emerald-500/20 bg-emerald-500/5 rounded-2xl animate-fade-in">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-[10px] font-black uppercase tracking-widest text-emerald-600">
                        {{ session('success') }}
                    </p>
                </div>
            </div>
        @endif

        <div class="card-premium overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                    <thead class="bg-vault-dark-100/30 dark:bg-vault-dark-900/30">
                        <tr>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Identity Node</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Class Type</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Authorization Status</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Stream Date</th>
                            <th
                                class="px-8 py-5 text-left text-[10px] font-black uppercase tracking-[0.2em] text-vault-dark-400">
                                Protocols</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-vault-dark-100 dark:divide-vault-dark-800">
                        @forelse($documents as $document)
                                            <tr class="group hover:bg-gold-premium-50/30 dark:hover:bg-gold-premium-900/5 transition-all">
                                                <td class="px-8 py-6 whitespace-nowrap">
                                                    <div class="flex items-center gap-3">
                                                        <div
                                                            class="w-10 h-10 rounded-xl bg-vault-dark-100 dark:bg-vault-dark-900 flex items-center justify-center text-xs font-black text-vault-dark-600 group-hover:bg-gold-premium-600 group-hover:text-white transition-all">
                                                            {{ substr($document->user->name, 0, 1) }}
                                                        </div>
                                                        <div>
                                                            <div
                                                                class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                                                {{ $document->user->name }}</div>
                                                            <div class="text-[10px] text-vault-dark-400 uppercase font-bold">
                                                                {{ $document->user->email }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="px-8 py-6">
                                                    <div
                                                        class="text-xs font-black text-vault-dark-600 dark:text-vault-dark-300 uppercase tracking-widest">
                                                        {{ $document->type }}</div>
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap">
                                                    <span
                                                        class="px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full 
                                                            {{ $document->status === 'approved' ? 'bg-emerald-500/10 text-emerald-600' :
                            ($document->status === 'rejected' ? 'bg-red-500/10 text-red-600' : 'bg-yellow-500/10 text-yellow-600') }}">
                                                        {{ $document->status }}
                                                    </span>
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap text-[10px] font-bold text-vault-dark-400 uppercase">
                                                    {{ $document->created_at->format('M d, Y H:i') }}
                                                </td>
                                                <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                                    <div class="flex items-center gap-4">
                                                        <a href="{{ route('admin.documents.show', $document) }}"
                                                            class="text-[10px] font-black text-blue-600 uppercase tracking-widest hover:text-blue-500 transition-colors">Inspect</a>

                                                        @if($document->status === 'pending')
                                                            <form action="{{ route('admin.documents.approve', $document) }}" method="POST"
                                                                class="inline">
                                                                @csrf
                                                                <button type="submit"
                                                                    class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-500 transition-colors">Authorize</button>
                                                            </form>
                                                            <button onclick="showRejectModal({{ $document->id }})"
                                                                class="text-[10px] font-black text-red-600 uppercase tracking-widest hover:text-red-500 transition-colors">Terminate</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-12 h-12 rounded-full bg-vault-dark-50 dark:bg-vault-dark-900/50 flex items-center justify-center mb-4">
                                            <svg class="w-6 h-6 text-vault-dark-200" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                        <p class="text-xs font-black text-vault-dark-400 uppercase tracking-widest">No
                                            Intelligence Data Detected</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($documents->hasPages())
            <div class="mt-8 glass p-4 rounded-3xl">
                {{ $documents->links() }}
            </div>
        @endif
    </div>

    <!-- Protocol Rejection Modal -->
    <div id="reject-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center p-6 sm:p-0">
        <div class="absolute inset-0 bg-vault-dark-950/80 backdrop-blur-sm" onclick="hideRejectModal()"></div>
        <div class="relative w-full max-w-md card-premium p-8 overflow-hidden animate-fade-in-up">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-lg font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">Protocol
                        Termination</h3>
                    <p class="text-[10px] text-red-500 uppercase tracking-widest font-black mt-1">Specify rejection
                        parameters</p>
                </div>
                <button onclick="hideRejectModal()"
                    class="text-vault-dark-300 hover:text-vault-dark-900 dark:hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="reject-form" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label for="admin_notes"
                        class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-2">Technical
                        Deficiencies</label>
                    <textarea name="admin_notes" id="admin_notes" rows="4" required
                        class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-red-500 focus:border-red-500 transition-all text-sm placeholder-vault-dark-300"
                        placeholder="Detail the failure parameters here..."></textarea>
                </div>

                <div class="flex gap-4">
                    <button type="button" onclick="hideRejectModal()"
                        class="flex-1 glass py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-vault-dark-100 transition-all">
                        Abort
                    </button>
                    <button type="submit"
                        class="flex-1 bg-red-600 text-white py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all">
                        Finalize Rejection
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showRejectModal(documentId) {
            const modal = document.getElementById('reject-modal');
            const form = document.getElementById('reject-form');
            form.action = `/admin/documents/${documentId}/reject`;
            modal.classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
        }
    </script>
</x-admin-layout>