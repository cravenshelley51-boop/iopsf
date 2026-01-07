@props(['links'])

<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    @foreach($links as $link)
        <x-nav-link 
            :href="route($link['route'])" 
            :active="request()->routeIs($link['active'] ?? $link['route'])"
        >
            {{ __($link['label']) }}
        </x-nav-link>
    @endforeach
</div> 