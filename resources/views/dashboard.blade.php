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
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user-contact-modify1') }}">
            [ {{ __("Your Contact info") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('photo-box-list') }}">
            [ {{ __("Your Uffizi' Gallery") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <!-- Open Contest list -->
            <a href="{{ route('contest-list') }}">
            [ {{ __("Contest Open ") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('organization-list') }}">
            [ {{ __("Organization List") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('federation-list') }}">
                [ {{ __("Federation List") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('add-user-role-organization') }}">
            [ {{ __("Add in Organization") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('add-organization') }}">
                [ {{ __("Add New Organization") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('add-user-role-federation') }}">
                [ {{ __("Add in Federation") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('add-federation') }}">
                [ {{ __("Add New Federation") }} ]
            </a>
        </div>
        . .
        <br style="clear:both;" /> 
        <hr class="my-4" />
        
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
