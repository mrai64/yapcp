@props(['contest', 'active' => ''])

<nav class="flex space-x-6 pb-2">
    <x-nav-link :href="route('organization.design.contest.modify-name', $contest)" 
        :active="$active == 'general'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Main data') }}
    </x-nav-link>
    . .
    <x-nav-link :href="route('organization.design.contest-section.listed', $contest)" 
        :active="$active == 'sections'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Sections') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.contest-jury.listed', $contest)" 
        :active="$active == 'juries'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Juries') }}
    </x-nav-link>
    <x-nav-link :href="route('organization.design.contest-award.listed', $contest)" 
        :active="$active == 'awards'"
        class="mb-4 fyk text-xl w-48 text-center inline-flex" >
        {{ __('Awards') }}
    </x-nav-link>
</nav>