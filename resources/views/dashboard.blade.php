<?php
/**
 * User Personal dashboard
 */

use App\Models\ContestJury;
use Illuminate\Support\Facades\Auth;

?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight">
            {{ __('Personal Dashboard') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <h3 class="mb-4 sm:px-6 lg:px-8">
            <a href="{{ route('user-contact-modify') }}">
            [ {{ __("Update your personal Contact info") }} ]
            </a>
            . .
            <a href="{{ route('photo-box-list') }}">
            [ {{ __("Your Uffizi' Gallery") }} ]
            </a>
            . . 
            <!-- Open Contest list -->
            <a href="{{ route('contest-list') }}">
            [ {{ __("Contest List Open to participate") }} ]
            </a>
            . .
            <a href="{{ route('organization-list') }}">
            [ {{ __("Organization List") }} ]
            </a>
            . .
            <a href="{{ route('federation-list') }}">
            [ {{ __("Federation List") }} ]
            </a>
            . .
        </h3>

        <!-- user roles -->
        <section name="user_roles" >
            <livewire:user.role.listed />
        </section>

        <!-- juror in contest... -->
        <section name="user_roles" class="mb-4 sm:px-6 lg:px-8 py-12">
            <livewire:contest.jury.listed />
        </section>
    </div>

</x-app-layout>
