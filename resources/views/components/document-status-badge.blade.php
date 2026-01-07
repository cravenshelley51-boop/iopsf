@props(['status'])

@php
    $classes = match($status) {
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        default => 'bg-yellow-100 text-yellow-800'
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
    {{ ucfirst($status) }}
</span> 

@php
    $classes = match($status) {
        'approved' => 'bg-green-100 text-green-800',
        'rejected' => 'bg-red-100 text-red-800',
        default => 'bg-yellow-100 text-yellow-800'
    };
@endphp

<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $classes }}">
    {{ ucfirst($status) }}
</span> 