<x-admin-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h2
                    class="text-4xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase leading-none">
                    Intelligence <span class="text-gold-premium-600">Requisition</span>
                </h2>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-vault-dark-400 mt-2">External
                    Authentication Request Protocol</p>
            </div>
            <a href="{{ route('admin.users.show', $user) }}"
                class="glass px-6 py-3 rounded-2xl flex items-center gap-3 group transition-all">
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
            <div class="absolute top-0 right-0 w-64 h-64 bg-gold-premium-500/5 rounded-full blur-3xl -mr-32 -mt-32">
            </div>

            <div class="relative z-10">
                <div class="mb-12">
                    <h3
                        class="text-xl font-black text-vault-dark-900 dark:text-white uppercase tracking-tight flex items-center gap-3">
                        <div class="w-2 h-6 bg-gold-premium-600 rounded-full"></div>
                        Initiate Request for {{ $user->name }}
                    </h3>
                    <p class="mt-2 text-xs text-vault-dark-400 uppercase font-bold tracking-widest leading-relaxed">
                        Specify the intelligence parameters required from the target entity. The entity will be signaled
                        and provided with a secure upload uplink.
                    </p>
                </div>

                <form action="{{ route('admin.documents.store-request', $user) }}" method="POST" class="space-y-8">
                    @csrf

                    <div class="space-y-6">
                        <!-- Document Type -->
                        <div>
                            <label for="type"
                                class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-3">Intelligence
                                Classification</label>
                            <select name="type" id="type"
                                class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4"
                                required>
                                <option value="" class="bg-white dark:bg-vault-dark-950">Select classification...
                                </option>
                                <option value="id_proof" class="bg-white dark:bg-vault-dark-950">ID Proof (Level 1)
                                </option>
                                <option value="address_proof" class="bg-white dark:bg-vault-dark-950">Address Proof
                                    (Level 2)</option>
                                <option value="bank_statement" class="bg-white dark:bg-vault-dark-950">Financial Ledger
                                    (Level 3)</option>
                            </select>
                            @error('type')
                                <p class="mt-2 text-[10px] font-black text-red-600 uppercase tracking-widest">{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Request Title -->
                        <div>
                            <label for="title"
                                class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-3">Protocol
                                Designation (Title)</label>
                            <input type="text" name="title" id="title"
                                class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4 placeholder-vault-dark-300"
                                placeholder="e.g., Government-issued ID, Utility Bill, etc." required>
                            @error('title')
                                <p class="mt-2 text-[10px] font-black text-red-600 uppercase tracking-widest">{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <!-- Additional Notes -->
                        <div>
                            <label for="notes"
                                class="block text-[10px] font-black text-vault-dark-400 uppercase tracking-widest mb-3">Directives
                                & Parameters (Optional)</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="w-full bg-vault-dark-100/50 dark:bg-vault-dark-900/50 border-vault-dark-200 dark:border-vault-dark-800 rounded-2xl focus:ring-gold-premium-500 focus:border-gold-premium-500 transition-all text-sm py-4 placeholder-vault-dark-300"
                                placeholder="Specify any granular requirements for the entity..."></textarea>
                            @error('notes')
                                <p class="mt-2 text-[10px] font-black text-red-600 uppercase tracking-widest">{{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-4 pt-4">
                        <a href="{{ route('admin.users.show', $user) }}"
                            class="flex-1 glass py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest text-center hover:bg-vault-dark-100 transition-all">
                            Cancel
                        </a>
                        <button type="submit"
                            class="flex-[2] bg-gold-premium-600 text-white py-4 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-gold-premium-700 shadow-xl shadow-gold-premium-600/20 transition-all">
                            Transmit Requisition
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-generate title based on document type
            document.getElementById('type').addEventListener('change', function () {
                const titleInput = document.getElementById('title');
                const type = this.value;

                if (type) {
                    const titles = {
                        'id_proof': 'Government-issued ID Identification',
                        'address_proof': 'Utility Bill or Residency Confirmation',
                        'bank_statement': 'Asset Liquidity Proof (Bank Statement)'
                    };

                    titleInput.value = titles[type] || '';
                }
            });
        </script>
    @endpush
</x-admin-layout>