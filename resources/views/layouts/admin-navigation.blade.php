<x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
    {{ __('Dashboard') }}
</x-nav-link>
<x-nav-link :href="route('admin.users.index')" :active="request()->routeIs('admin.users.*')">
    {{ __('Users') }}
</x-nav-link>
<x-nav-link :href="route('admin.withdrawal-requests.index')"
    :active="request()->routeIs('admin.withdrawal-requests.*')">
    {{ __('Withdrawal Requests') }}
</x-nav-link>