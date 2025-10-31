<!-- Guest Navigation Links -->
<div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
    <x-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
        {{ __('Home') }}
    </x-nav-link>
    <x-nav-link href="{{ route('daily-verse.index') }}" :active="request()->routeIs('daily-verse.*')">
        {{ __('Verse of the Day') }}
    </x-nav-link>
    <x-nav-link href="{{ route('bible-verse') }}" :active="request()->routeIs('bible-verse')">
        {{ __('Bible Verses') }}
    </x-nav-link>
</div>

<!-- Responsive Navigation Menu -->
<div class="sm:hidden">
    <div class="pt-2 pb-3 space-y-1">
        <x-responsive-nav-link href="{{ route('home') }}" :active="request()->routeIs('home')">
            {{ __('Home') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{ route('daily-verse.index') }}" :active="request()->routeIs('daily-verse.*')">
            {{ __('Verse of the Day') }}
        </x-responsive-nav-link>
        <x-responsive-nav-link href="{{ route('bible-verse') }}" :active="request()->routeIs('bible-verse')">
            {{ __('Bible Verses') }}
        </x-responsive-nav-link>
    </div>
</div>