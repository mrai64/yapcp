<?php

/**
 * User Dashboard
 * All user can, except login logout, can start from here.
 *
 */

use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    //
    public function with()
    {
        $user  = Auth::user();
        return [
            'user'                  => $user,
            'userContact'           => $user->userContact,
            'userRolesOrganizations' => $user->activeUserOrganizations,
        ];
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(":name, that's Your Dashboard", ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="my-2" />
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

                <!-- errors list -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <h3 class="fyk text-xl font-bold">{{ __("You") }}</h3>
                <div class="border rounded-md px-4 py-6 mb-6">
                    <x-yapcp.inline-link 
                        txt="View Contact infos" 
                        url="{{ route('user.contact.show') }}" />
                    <x-yapcp.inline-link
                        txt="Update Contact infos"
                        url="{{ route('user.contact.modify1', ['user_contact' => $userContact]) }}" />
                    <x-yapcp.inline-link 
                        txt="Add Work to Gallery" 
                        url="{{ route('user.work.add') }}" />
                    <x-yapcp.inline-link 
                        txt="Your 📋 Gallery" 
                        url="{{ route('user.work.listed1') }}" />
                    <x-yapcp.inline-link 
                        txt="Your 🌇 Gallery" 
                        url="{{ route('user.work.listed2') }}" />
                    <x-yapcp.inline-link 
                        txt="The Manual" 
                        url="{{ url('/docs') }}" />
                    <x-yapcp.inline-link 
                        txt="Change password" 
                        url="{{ url('/user/profile') }}" />
                    @if ($user->isAdmin())
                    <x-yapcp.inline-link 
                        txt="ADMIN Dashboard" 
                        url="{{ route('admin.dashboard') }}" />
                    @endif
                </div>

                <h3 class="fyk text-xl font-bold">{{ __("Lists") }}</h3>
                <div class="border rounded-md px-4 py-6 mb-6">
                    <x-yapcp.inline-link 
                        txt="Open Contest Board" 
                        url="{{ route('user.contest.listed-open') }}" />
                    <x-yapcp.inline-link
                        txt="Closed Contest Board" 
                        url="{{ route('user.contest.listed-closed', ['contestYear' => now()->year ]) }}" />
                    <x-yapcp.inline-link 
                        txt="Organizations List" 
                        url="{{ route('organization.listed') }}" />
                    <x-yapcp.inline-link 
                        txt="Federation list" 
                        url="{{ route('federation.listed') }}" />
                </div>

                @if ($userRolesOrganizations->isNotEmpty())
                <h3 class="fyk text-xl font-bold">
                    <!-- organizations only -->
                    {{ __("Member of ...") }}
                </h3>
                <div class="border rounded-md px-4 py-6 mb-6">
                    @foreach ($userRolesOrganizations as $userRole)
                    <x-yapcp.inline-link 
                        txt="{{ $userRole->organization->name }}" 
                        url="{{ route('organization.dashboard', ['organization' => $userRole->organization]) }}" />
                    @endforeach
                </div>
                @endif

                @if ($user->isAdmin())
                <h3 class="fyk text-xl font-bold">{{ __("Federations [admin only]") }}</h3>
                <x-yapcp.inline-link 
                    txt="New Federation" 
                    url="{{ route('federation.add') }}" />
                @endif

                <h3 class="fyk text-xl font-bold mb-4">{{ __("Contests (Participant | Juror)") }}</h3>
                <!-- PARTICIPANT IN - applied contest-->
                @livewire('user.contest.applied', ['userId' => $user->id])
                <!-- PARTICIPATED IN - applied contest-->
                @livewire('user.contest.closed', ['userId' => $user->id])
                <!-- JUROR IN - applied contest-->
                @livewire('user.contest.juror', ['userId' => $user->id])


            </div>
        </div>
    </div>
    <x-footer-app />
</div>
