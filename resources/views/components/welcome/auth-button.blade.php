@props(['href' => '#'])

<a href="{{ $href }}" {{ $attributes->merge(['class' => 'inline-flex items-center rounded-md bg-slate-900 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-600 border border-[#D4AF37]/20']) }}>
    {{ $slot }}
</a> 