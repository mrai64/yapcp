<?php

/**
 * Organization dashboard
 * 
 * access granted to alla organization members and admin
 * 
 */

use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;


new class extends Component {

    public Organization $organization;
    public UserContact $userContact;

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
        $this->userContact = Auth::user()->contact;
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
            {{ __(':name Dashboard' , ['name' => $organization->name] ) }}
        </h2>
        <hr class="mb-4" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-header-link-app 
            txt="Update Org Infos" 
            url="{{ route('organization.modify', ['organization' => $organization]) }}" />
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

                <h3 class="fyk text-2xl font-bold mb-4">{{ __("Members") }}</h3>
                <x-header-link-app 
                    txt="Add new Member" 
                    url="#" />
                <x-header-link-app 
                    txt="Members list" 
                    url="#" />


                <h3 class="fyk text-2xl font-bold mb-4">{{ __("Contest") }}</h3>
                <x-header-link-app 
                    txt="Design new Contest" 
                    url="#" />
                <x-header-link-app 
                    txt="Manage Open Contest" 
                    url="#" />
                <x-header-link-app 
                    txt="View Past Contest" 
                    url="#" />

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
