<?php

/**
 * User dashboard
 *
 * TODO Organization dashboard, Admin dashboard
 */

use function Livewire\Volt\state;
use function Livewire\Volt\with;

// Pass the authenticated user to the Blade view
with([
    'user' => auth()->user(),
    'userContact' => auth()->user()->contact,
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
                <x-header-link-app 
                    txt="View Contact infos" 
                    url="{{ route('user.contact.show') }}" />
                <x-header-link-app
                    txt="Update Contact infos"
                    url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
                <x-header-link-app 
                    txt="The Manual" 
                    url="{{ url('/docs') }}" />
                <x-header-link-app 
                    txt="Change password" 
                    url="{{ url('/user/profile') }}" />

                <h3 class="fyk text-xl font-bold mb-4">{{ __("Lists") }}</h3>
                <x-header-link-app 
                    txt="Open Contest List" 
                    url="{{ route('user.contest.listed') }}" />
            </div>
        </div>
    </div>
    <x-footer-app />
</div>
