<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Two-Factor Authentication') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if (session('status'))
                        <div class="mb-4 font-medium text-sm text-green-600">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if (Auth::user()->two_factor_enabled)
                        <div class="mb-4">
                            <p class="text-gray-600">Two-factor authentication is currently enabled for your account.</p>
                        </div>

                        <form method="POST" action="{{ route('two-factor.disable') }}" class="space-y-6">
                            @csrf
                            <div>
                                <x-input-label for="code" :value="__('Verification Code')" />
                                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <x-danger-button>
                                    {{ __('Disable Two-Factor Authentication') }}
                                </x-danger-button>
                            </div>
                        </form>
                    @else
                        <div class="mb-4">
                            <p class="text-gray-600">Scan this QR code with your authenticator app:</p>
                            <div class="mt-4">
                                <img src="{{ $qrCode }}" alt="QR Code">
                            </div>
                            <p class="mt-4 text-gray-600">Or enter this secret key manually:</p>
                            <p class="mt-2 font-mono bg-gray-100 p-2 rounded">{{ $secretKey }}</p>
                        </div>

                        <form method="POST" action="{{ route('two-factor.enable') }}" class="space-y-6">
                            @csrf
                            <input type="hidden" name="secret" value="{{ $secretKey }}">
                            
                            <div>
                                <x-input-label for="code" :value="__('Verification Code')" />
                                <x-text-input id="code" class="block mt-1 w-full" type="text" name="code" required autofocus />
                                <x-input-error :messages="$errors->get('code')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-end">
                                <x-primary-button>
                                    {{ __('Enable Two-Factor Authentication') }}
                                </x-primary-button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 