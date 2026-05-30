<?php

/**
 * User dashboard
 *
 */
use function Livewire\Volt\{state, with};

// Pass the authenticated user to the Blade view
with([
    'user' => auth()->user(),
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
                <h3 class="fyk text-xl font-bold mb-4">{{ __("Questions?") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ url('/docs') }}">
                    [ {{ __("The Manual") }} ]
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("About you") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user.gallery') }}">
                        [ {{ __("Your Uffizi´ Gallery") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a  href="{{ route('user-contact.modify1', ['userContact' => $user->userContact ]) }}"
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
                    <a href="{{ route('organization.list') }}">
                        [ {{ __("Organization List") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user.organization.add') }}">
                        [ {{ __("Add a new Org") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user-role.add.organization') }}">
                        [ {{ __("Add you in an Org") }} ]
                    </a>
                </div>
                . .
                <br />
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('federation.list') }}">
                        [ {{ __("Federation List") }} ]
                    </a>
                </div>
                . .
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('user-role.add.federation') }}">
                        [ {{ __("Add you in a Fed") }} ]
                    </a>
                </div>
                . .
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("Role(s) assigned to you") }}</h3>
                <livewire:user.role.listed />
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Contest(s) participant") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('contest.list') }}">
                        [ {{ __("Open Contest List") }} ]
                    </a>
                </div>
            </div>

            @can('access-juror')
            <div class="bg-indigo-50 border-l-4 border-indigo-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Jury member") }}</h3>
                <livewire:contest.jury.listed />
            </div>
            @endcan

            @can('access-organization')
            <div class="bg-green-50 border-l-4 border-green-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Organization member") }}</h3>
                <livewire:organization.dashboard />
            </div>
            @endcan

            @can('access-admin')
            <div class="bg-green-50 border-l-4 border-green-500 overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("As Admins member") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('admin.dashboard') }}" 
                        class="mt-2 inline-block bg-red-600 text-white px-4 py-2 rounded">
                        [ {{ __("Admin Dashboard") }} ]
                    </a>
                </div>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ route('federation.add') }}">
                        [ {{ __("Add a new Fed") }} ]
                    </a>
                </div>
                . .
            </div>
            @endcan

    </div>
    <footer class="py-16 text-center text-sm text-black dark:text-white/70 text-muted">
        &copy; {{ date('Y')}} - {{ config('app.name') }} - version {{ $appVersion }} guest
    </footer>
</div>

