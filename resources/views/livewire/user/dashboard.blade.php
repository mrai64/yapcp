<?php

/**
 * User dashboard
 *
 */

use function Livewire\Volt\state;
use function Livewire\Volt\with;

// Pass the authenticated user to the Blade view
with([
    'user' => auth()->user(),
    'userContact' => auth()->user()->contact,
    'userRolesOrganizations' => auth()->user()->activeUserOrganizations,
]);

?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __(':name Dashboard' , ['name' => $user->name] ) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">

                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif

                <h3 class="fyk text-xl font-bold mb-4">{{ __("You") }}</h3>
                <x-yapcp.header-link 
                    txt="View Contact infos" 
                    url="{{ route('user.contact.show') }}" />
                <x-yapcp.header-link
                    txt="Update Contact infos"
                    url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
                <x-yapcp.header-link 
                    txt="Add Work to Gallery" 
                    url="{{ route('user.work.add') }}" />
                <x-yapcp.header-link 
                    txt="Your 📋 Gallery" 
                    url="{{ route('user.work.listed1') }}" />
                <x-yapcp.header-link 
                    txt="Your 🌇 Gallery" 
                    url="{{ route('user.work.listed2') }}" />
                <x-yapcp.header-link 
                    txt="The Manual" 
                    url="{{ url('/docs') }}" />
                <x-yapcp.header-link 
                    txt="Change password" 
                    url="{{ url('/user/profile') }}" />

                <h3 class="fyk text-xl font-bold mb-4">{{ __("Lists") }}</h3>
                <x-yapcp.header-link 
                    txt="Open Contest List" 
                    url="{{ route('user.contest.listed') }}" />
                <x-yapcp.header-link 
                    txt="Organizations List" 
                    url="{{ route('organization.listed') }}" />

                @if ($userRolesOrganizations->isNotEmpty())
                <h3 class="fyk text-xl font-bold mb-4">
                    {{ __("Member of ...") }}
                </h3>
                    @foreach ($userRolesOrganizations as $userRole)
                    <x-yapcp.inline-link 
                        txt="{{ $userRole->organization->name }}" 
                        url="{{ route('organization.dashboard', ['organization' => $userRole->organization]) }}" />
                    @endforeach
                @endif

                @if ($user->isAdmin())
                <h3 class="fyk text-xl font-bold mb-4">{{ __("Federations [admin only]") }}</h3>
                <x-yapcp.header-link 
                    txt="Federation list" 
                    url="{{ route('federation.listed') }}" />
                <x-yapcp.header-link 
                    txt="New Federation" 
                    url="{{ route('federation.add') }}" />

                @endif
            </div>
        </div>
    </div>
    <x-footer-app />
</div>
