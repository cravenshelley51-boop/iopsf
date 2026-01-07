<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- System Settings -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">System Settings</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span>Maintenance Mode</span>
                                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Toggle
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Email Notifications</span>
                                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Configure
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Security Settings -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-medium">Security Settings</h3>
                            <div class="space-y-2">
                                <div class="flex items-center justify-between">
                                    <span>Two-Factor Authentication</span>
                                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Enable
                                    </button>
                                </div>
                                <div class="flex items-center justify-between">
                                    <span>Session Timeout</span>
                                    <button class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                                        Configure
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 