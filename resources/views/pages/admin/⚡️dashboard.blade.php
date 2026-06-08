<?php

use function Livewire\Volt\{state, with};

// Pass the authenticated user to the Blade view
with([
    'user' => auth()->user(),
    'isAdmin' => auth()->user()->isAdmin(),
]);

?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight fyk">
            {{ __(':name Admin dashboard' , ['name' => $user->name] ) }}
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
                    <a href="{{ route('user.dashboard' , ['user' => $user ]) }}">
                        [ {{ __("Back to User dashboard") }} ]
                    </a>
                </div>
                . .
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("On Users") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ url('/docs') }}">
                    [ {{ __("The Manual") }} ]
                    </a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h3 class="fyk text-xl font-bold mb-4">{{ __("On contest") }}</h3>
                <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
                    <a href="{{ url('/docs') }}">
                    [ {{ __("The Manual") }} ]
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>