<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2
                    class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase leading-none">
                    Intelligence <span class="text-gold-premium-600">Inspection</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-vault-dark-400 mt-2">Detailed Document
                    Analysis & Verification</p>
            </div>
            <a href="{{ route('admin.documents.index') }}"
                class="glass px-6 py-3 rounded-2xl flex items-center gap-3 group transition-all">
                <svg class="w-4 h-4 text-vault-dark-600 group-hover:-translate-x-1 transition-transform" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="text-[10px] font-black uppercase tracking-widest text-vault-dark-700">Abort
                    Inspection</span>
            </a>
        </div>
    </x-slot>

    <div class="space-y-8 pb-12">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Document Meta -->
            <div class="lg:col-span-1 space-y-8">
                <div class="card-premium p-8">
                    <h3
                        class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500 mb-8 flex items-center gap-2">
                        <div class="w-1 h-4 bg-gold-premium-600 rounded-full"></div>
                        Metadata Matrix
                    </h3>

                    <div class="space-y-6">
                        <div class="p-4 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                            <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400 mb-1">Entity
                                Node</p>
                            <p class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                {{ $document->user->name }}</p>
                        </div>

                        <div class="p-4 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                            <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400 mb-1">
                                Intelligence Class</p>
                            <p class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                {{ $document->type }}</p>
                        </div>

                        <div class="p-4 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                            <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400 mb-1">Current
                                Protocol</p>
                            <span
                                class="mt-1 px-3 py-1 text-[10px] font-black uppercase tracking-widest rounded-full inline-block
                                {{ $document->status === 'approved' ? 'bg-emerald-500/10 text-emerald-600' :
    ($document->status === 'rejected' ? 'bg-red-500/10 text-red-600' : 'bg-yellow-500/10 text-yellow-600') }}">
                                {{ $document->status }}
                            </span>
                        </div>

                        <div class="p-4 rounded-2xl glass border border-vault-dark-100 dark:border-vault-dark-800">
                            <p class="text-[10px] font-black uppercase tracking-widest text-vault-dark-400 mb-1">Stream
                                Synchronized</p>
                            <p class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                {{ $document->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-premium p-8">
                    <h3
                        class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500 mb-8 flex items-center gap-2">
                        <div class="w-1 h-4 bg-emerald-500 rounded-full"></div>
                        Action Matrix
                    </h3>

                    <div class="space-y-4">
                        <a href="{{ route('admin.documents.download', $document) }}"
                            class="w-full flex items-center justify-center gap-3 px-6 py-4 glass border border-vault-dark-100 dark:border-vault-dark-800 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:border-gold-premium-500/30 transition-all group">
                            <svg class="w-4 h-4 text-vault-dark-600 group-hover:text-gold-premium-600 transition-colors"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Export Intel
                        </a>

                        @if($document->status === 'pending')
                            <div class="grid grid-cols-2 gap-4 pt-4">
                                <form action="{{ route('admin.documents.approve', $document) }}" method="POST"
                                    class="w-full">
                                    @csrf
                                    <button type="submit"
                                        class="w-full px-6 py-4 bg-emerald-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-emerald-700 shadow-lg shadow-emerald-600/20 transition-all">
                                        Authorize
                                    </button>
                                </form>
                                <button onclick="showRejectModal()"
                                    class="w-full px-6 py-4 bg-red-600 text-white rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-red-700 shadow-lg shadow-red-600/20 transition-all">
                                    Terminate
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Visual Intel (Preview) -->
            <div class="lg:col-span-2">
                <div class="card-premium p-8 h-full flex flex-col">
                    <h3
                        class="text-sm font-black uppercase tracking-[0.3em] text-vault-dark-500 mb-8 flex items-center gap-2">
                        <div class="w-1 h-4 bg-blue-500 rounded-full"></div>
                        Visual Intelligence Stream
                    </h3>

                    <div
                        class="flex-1 rounded-3xl overflow-hidden glass border border-vault-dark-100 dark:border-vault-dark-800 bg-vault-dark-50/50 dark:bg-vault-dark-950/50 p-4">
                        @if(in_array(pathinfo($document->file_path, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                            <div class="flex items-center justify-center min-h-[400px]">
                                <img src="{{ Storage::url($document->file_path) }}" alt="Document Preview"
                                    class="max-w-full h-auto rounded-xl shadow-2xl">
                            </div>
                        @else
                            <div class="flex flex-col items-center justify-center h-full min-h-[400px] text-center">
                                <div
                                    class="w-20 h-20 rounded-3xl bg-vault-dark-100 dark:bg-vault-dark-900 flex items-center justify-center mb-6">
                                    <svg class="w-10 h-10 text-vault-dark-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <p class="text-xs font-black text-vault-dark-500 uppercase tracking-widest">Encrypted
                                    Format: Preview Disabled</p>
                                <p class="text-[10px] text-vault-dark-400 mt-2 uppercase font-bold tracking-tighter">
                                    Requires external decryption (PDF format)</p>
                                <a href="{{ route('admin.documents.download', $document) }}"
                                    class="mt-8 inline-flex items-center gap-2 text-[10px] font-black text-gold-premium-600 uppercase tracking-widest hover:text-gold-premium-500 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    Execute Export to Verify
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
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

            <form action="{{ route('admin.documents.reject', $document) }}" method="POST" class="space-y-6">
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
        function showRejectModal() {
            document.getElementById('reject-modal').classList.remove('hidden');
        }

        function hideRejectModal() {
            document.getElementById('reject-modal').classList.add('hidden');
        }
    </script>
</x-admin-layout>