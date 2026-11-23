@props(['circuit', 'active' => ''])

<nav class="flex space-x-6 pb-2">
    <!-- Organization Circuit Design / main nav bar -->
    <x-nav-link :href="route('organization.design.circuit.modify-name', ['contest' => $circuit])" 
        :active="$active == 'general'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Main data') }}
    </x-nav-link>
    <!-- Patronages are contest related -->
    <x-nav-link :href="route('organization.design.circuit-section.listed', $circuit)" 
        :active="$active == 'sections'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Sections') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-jury.listed', $circuit)" 
        :active="$active == 'juries'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Juries') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-award.listed', $circuit)" 
        :active="$active == 'awards'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Awards') }}
    </x-nav-link>
</nav>