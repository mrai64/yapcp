<?php

/**
 * User Organization Add
 * 
 * User, after check his/her organization is missing,
 * can add and become automatically "member of"
 * 
 */

use App\Models\Organization;
use App\Models\UserContact;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {

    public UserContact $userContact;

    public string $organizationName;

    public string $country_id;

    public string $organizationEmail;

    public string $organizationWebsite;

    public string $organizationContact;

    // mount() yes
    public function mount() 
    {
        $this->userContact = Auth::user()->contact;
        $this->organizationName = '';
        $this->country_id = $this->userContact->country_id;
        $this->organizationEmail = '';
        $this->organizationWebsite = '';
        $this->organizationContact = '';
    }

    public function rules(): array
    {
        return [
            'country_id'          => 'required|string|exists:countries,id',
            'organizationName'    => 'required|string|min:3|max:255',
            'organizationEmail'   => 'required|string|email|max:255|unique:organizations,email',
            'organizationWebsite' => 'nullable|string|url|max:255|unique:organizations,website',
            'organizationContact' => 'nullable|string|max:1000',
        ];
    }

    public function addOrganization()
    {
        $validate = $this->validate();

        $organization = Organization::updateOrCreate(
            [
                'email'          => $validate['organizationEmail'],
            ],
            [
                'name'          => $validate['organizationName'],
                'country_id'    => $validate['country_id'],
                'website'       => $validate['organizationWebsite'],
                'contact'       => $validate['organizationContact'],
            ]
        );

        return redirect()
            ->route('organization.listed')
            ->with('success', __("New Organization added successfully"));

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Add a new Organization', ['name' => $userContact->first_name] ) }}
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

                <form wire:submit="addOrganization">
                    @csrf

                <!-- organizationName -->
                <div class="mb-4">
                    <x-input-label for="organizationName" :value="__('Organization name, english')" />
                    <x-text-input wire:model="organizationName" id="organizationName" name="organizationName" class="block mt-1 w-full" type="text" required />
                    <x-input-error for="organizationName" class="mt-2" />
                </div>

                <!-- country select -->
                <x-select-country-app wire:model="country_id" :country_id="$userContact->country_id" /> 

                <!-- organizationContact -->
                <div class="mb-4">
                    <style>textarea {resize:vertical;}</style>
                    <x-input-label for="organizationContact" :value="__('Contact info, HQ postal address, english')" />
                    <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="organizationContact"
                        wire:model="organizationContact"
                    >{{ old('organizationContact') }}</textarea>
                    <x-input-error for="organizationContact" class="mt-2" />
                </div>

                <!-- organizationEmail -->
                <div class="mb-4">
                    <x-input-label for="organizationEmail" :value="__('Email')" />
                    <x-text-input wire:model="organizationEmail" id="organizationEmail" name="organizationEmail" class="block mt-1 w-full" type="email" required />
                    <x-input-error for="organizationEmail" class="mt-2" />
                </div>

                <!-- organizationWebsite -->
                <div class="mb-4">
                    <x-input-label for="organizationWebsite" :value="__('official website')" />
                    <x-text-input wire:model="organizationWebsite" id="organizationWebsite" name="organizationWebsite" class="block mt-1 w-full" type="url" required />
                    <x-input-error for="organizationWebsite" class="mt-2" />
                </div>


                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check all, then Add') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
