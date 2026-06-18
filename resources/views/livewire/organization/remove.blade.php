<?php

/**
 * Organization remove
 *
 * Not here but after a job delete organization-related records
 * with a job thru by an observer
 *
 *
 */

use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

new class extends Component {

    public UserContact $userContact;

    public Organization $organization;

    public string $organizationName;

    public string $organizationCountryId;

    public string $organizationEmail;

    public string $organizationWebsite;

    public string $organizationContact;

    // mount() yes
    public function mount(Organization $organization)
    {
        $this->userContact            = Auth::user()->contact;
        $this->organization           = $organization;
        $this->organizationName       = $organization->name;
        $this->organizationCountryId  = $organization->country_id;
        $this->organizationEmail      = $organization->email;
        $this->organizationWebsite    = $organization?->website ?? '';
        $this->organizationContact    = $organization?->contact ?? '';
    }

    public function removeOrganization()
    {
        $this->organization->delete();

        return redirect()
            ->route('organization.listed')
            ->with('success', __("Your Organization was removed successfully"));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, REMOVE Organization', ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="mb-4" />
        <x-header-link-app 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
        <x-header-link-app 
            txt="Organization List" 
            url="{{ route('organization.listed') }}" />
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

                <form wire:submit="removeOrganization">
                    @csrf

                <!-- organizationName -->
                <div class="mb-4">
                    <x-input-label for="organizationName" :value="__('Organization name')" />
                    <x-text-input wire:model="organizationName" id="organizationName" name="organizationName" class="block mt-1 w-full" type="text" disabled />
                </div>

                <!-- country select -->
                <div class="mb-4">
                    <x-input-label for="organizationCountryId" :value="__('Country / Nation')" />
                    <x-text-input wire:model="organizationCountryId" id="organizationCountryId" name="organizationCountryId" class="block mt-1 w-full" type="text" disabled />
                </div>

                <!-- organizationContact -->
                <div class="mb-4">
                    <style>textarea {resize:vertical;}</style>
                    <x-input-label for="organizationContact" :value="__('Contact info, HQ postal address, english')" />
                    <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="organizationContact"
                        wire:model="organizationContact"
                        disabled
                    >{{ old('organizationContact') }}</textarea>
                </div>

                <!-- organizationEmail -->
                <div class="mb-4">
                    <x-input-label for="organizationEmail" :value="__('Email')" />
                    <x-text-input wire:model="organizationEmail" id="organizationEmail" name="organizationEmail" class="block mt-1 w-full" type="email" disabled />
                </div>

                <!-- organizationWebsite -->
                <div class="mb-4">
                    <x-input-label for="organizationWebsite" :value="__('official website')" />
                    <x-text-input wire:model="organizationWebsite" id="organizationWebsite" name="organizationWebsite" class="block mt-1 w-full" type="url" disabled />
                    <x-input-error for="organizationWebsite" class="mt-2" />
                </div>


                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Are you SURE!? Delete Organization and all related records. Are You SURE?') }}
                    </x-button>
                </form>


            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
