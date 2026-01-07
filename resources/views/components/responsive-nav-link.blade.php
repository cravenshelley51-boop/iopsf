@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-yellow-500 text-start text-base font-medium text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/10 focus:outline-none focus:text-yellow-600 dark:focus:text-yellow-400 focus:bg-yellow-100 dark:focus:bg-yellow-900/20 focus:border-yellow-600 transition duration-200 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-slate-700 dark:text-slate-300 hover:text-yellow-600 dark:hover:text-yellow-400 hover:bg-yellow-50 dark:hover:bg-yellow-900/10 hover:border-yellow-300 dark:hover:border-yellow-600 focus:outline-none focus:text-yellow-600 dark:focus:text-yellow-400 focus:bg-yellow-50 dark:focus:bg-yellow-900/10 focus:border-yellow-300 dark:focus:border-yellow-600 transition duration-200 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
