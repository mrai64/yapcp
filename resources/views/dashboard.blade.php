<?php
/**
 * User dashboard
 */

use App\Models\ContestJury;
use Illuminate\Support\Facades\Auth;

?>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('user-contact-modify') }}">
                    {{ __("Update your personal Contact info") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('photo-box-list') }}">
                    {{ __("Your Uffizi' Gallery") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Open Contest list -->
                    <a href="{{ route('contest-list') }}">
                    {{ __("Contest List to participate") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('organization-list') }}">
                    {{ __("Organization List") }}
                    </a>
                </div>
            </div>
        </div>
        <div class="inline-flex h-16 w-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <a href="{{ route('federation-list') }}">
                    {{ __("Federation List") }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class_="pb-4">
        <div class_="w-full sm:px-6 lg:px-8">
            <p class="fyk text-xl">{{ __("Your roles in platform") }}</p>
            <livewire:user.role.listed />
        </div>
    </div>

    <div class_="pb-4">
        <div class="w-full sm:px-6 lg:px-8">
            <livewire:contest.jury.listed />
        </div>
    </div>


</x-app-layout>
