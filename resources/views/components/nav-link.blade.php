@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-3 py-2 border-b-2 border-yellow-500 text-sm font-medium leading-5 text-yellow-600 dark:text-yellow-400 focus:outline-none focus:border-yellow-600 transition duration-200 ease-in-out'
            : 'inline-flex items-center px-3 py-2 border-b-2 border-transparent text-sm font-medium leading-5 text-slate-700 dark:text-slate-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:border-yellow-300 dark:hover:border-yellow-600 focus:outline-none focus:text-yellow-600 dark:focus:text-yellow-400 focus:border-yellow-300 dark:focus:border-yellow-600 transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
