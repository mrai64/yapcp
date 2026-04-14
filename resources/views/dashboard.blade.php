<?php
/**
 * User Personal dashboard
 */

use App\Models\ContestJury;
use Illuminate\Support\Facades\Auth;

?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Personal Dashboard') }}
        </h2>
    </x-slot>
    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user-contact.modify1') }}">
            [ {{ __("Your Contact info") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a  href="{{ route('user.profile') }}"
                rel="noopener noreferrer">
            [ {{ __('Email, password') }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user.gallery') }}">
            [ {{ __("Your Uffizi' Gallery") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <!-- Open Contest list -->
            <a href="{{ route('contest.list') }}">
            [ {{ __("Contest Open ") }} ]
            </a>
        </div>
        <br />
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('organization.list') }}">
            [ {{ __("Organization List") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user-role.add.organization') }}">
            [ {{ __("Add in Organization") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user.organization.add') }}">
                [ {{ __("Add new Organization") }} ]
            </a>
        </div>
        <br />
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('federation.list') }}">
                [ {{ __("Federation List") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('user-role.add.federation') }}">
                [ {{ __("Add in Federation") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('federation.add') }}">
                [ {{ __("Add new Federation") }} ]
            </a>
        </div>
        . .
        <br style="clear:both;" />
        <p class="small">
            {{ __("Your personal data will be used when you want to register ") }}
            {{ __("for the next photo contest, or to contact you if you are  ") }}
            {{ __("chosen as judges of a contest.                            ") }}
        </p>
        <br />
        <hr class="my-4" />

        <!-- user roles in... -->
        <section name="user_roles" >
            <livewire:user.role.listed />
        </section>

        <!-- juror in contest... -->
        <section name="user_roles" class="mb-4 sm:px-6 lg:px-8 py-12">
            <livewire:contest.jury.listed />
        </section>
    </div>
</x-app-layout>
