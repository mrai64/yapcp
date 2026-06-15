<?php

/**
 * User dashboard
 *
 */

use App\Models\User;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;
use function Livewire\Volt\with;

// Pass the authenticated user to the Blade view
with(function (?User $targetUser = null) {
    // Se targetUser è passato via route model binding lo usiamo, altrimenti usiamo l'autenticato
    $currentUser = $targetUser ?? auth()->user();
    
    return [
        'user' => $currentUser, // Questo diventerà $user nel blade
        'userContactId' => $currentUser->userContact?->id,
        'appVersion' => (string) config('app.version', '1.0.0'),
    ];
});
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
                <h3 class="fyk text-xl font-bold mb-4">{{ __("Questions?") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ url('/docs') }}">
                    [ {{ __("The Manual") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('organization.list') }}">
                        [ {{ __("Organization List") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('federation.list') }}">
                        [ {{ __("Federation List") }} ]
                    </a>
                </div>
                . .
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">
                    {{ __("About you") }}
                </h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user.gallery') }}">
                        [ {{ __("Your Uffizi´ Gallery") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a  href="{{ $userContactId ? route('user-contact.modify1', ['userContact' => $userContactId]) : '#' }}"
                        rel="noopener noreferrer">
                        [ {{ __('Change contact infos') }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a  href="{{ route('user.profile') }}"
                        rel="noopener noreferrer">
                        [ {{ __('Change email / password') }} ]
                    </a>
                </div>
                . .
                <br />
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user.organization.add') }}">
                        [ {{ __("Add a new Org") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user_role.organization.add') }}">
                        [ {{ __("Add you in an Org") }} ]
                    </a>
                </div>
                . .
            </div>
    </div>
    <x-footer-app />
</div>
