@props(['circuit', 'active' => ''])

<nav class="flex space-x-6 pb-2">
    <x-nav-link :href="route('organization.design.circuit.modify-name', ['contest' => $circuit])" 
        :active="$active == 'general'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Main data') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-patronage.listed', ['contest' => $circuit])" 
        :active="$active == 'patronages'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Patronages') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-section.listed', ['contest' => $circuit])" 
        :active="$active == 'sections'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Sections') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-jury.listed', ['contest' => $circuit])" 
        :active="$active == 'juries'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Juries') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.circuit-award.listed', ['contest' => $circuit])" 
        :active="$active == 'awards'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Awards') }}
    </x-nav-link>
</nav>