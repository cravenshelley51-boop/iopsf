<x-admin-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-black tracking-tight text-vault-dark-900 dark:text-white uppercase">
            System <span class="text-gold-premium-600">Parameters</span>
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-8 pb-12">
        <div class="card-premium p-8 sm:p-12">
            <div class="mb-10">
                <h3 class="text-lg font-bold text-vault-dark-900 dark:text-white flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-gold-premium-500/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-gold-premium-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    Global Configurations
                </h3>
                <p class="text-xs text-vault-dark-400 mt-1 uppercase tracking-widest font-black">Manage core application
                    protocols and visual identifiers</p>
            </div>

            <div class="space-y-12">
                <div
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 group hover:border-gold-premium-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                Main Infrastructure</h4>
                            <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Base
                                application node settings and identity</p>
                        </div>
                        <button
                            class="text-[10px] font-black text-gold-premium-600 uppercase tracking-widest hover:text-gold-premium-500">Configure</button>
                    </div>
                </div>

                <div
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 group hover:border-emerald-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                Security Encryption</h4>
                            <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">Access
                                control lists and multi-factor protocols</p>
                        </div>
                        <button
                            class="text-[10px] font-black text-emerald-600 uppercase tracking-widest hover:text-emerald-500">Enable</button>
                    </div>
                </div>

                <div
                    class="p-6 glass rounded-2xl border border-vault-dark-100 dark:border-vault-dark-800 group hover:border-purple-500/30 transition-all duration-300">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-sm font-black text-vault-dark-900 dark:text-white uppercase tracking-tight">
                                Telemetry & Logging</h4>
                            <p class="text-[10px] text-vault-dark-400 mt-1 uppercase tracking-tighter font-bold">System
                                performance metrics and audit trails</p>
                        </div>
                        <button
                            class="text-[10px] font-black text-purple-600 uppercase tracking-widest hover:text-purple-500">View
                            Logs</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>