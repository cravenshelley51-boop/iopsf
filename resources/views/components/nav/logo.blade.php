<div class="shrink-0 flex items-center">
    <a href="{{ auth()->user()->hasRole('admin') ? route('admin.dashboard') : route('client.dashboard') }}">
        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
    </a>
</div> 