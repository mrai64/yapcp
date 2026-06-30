<?php

/**
 * User Contact modify 2nd of five
 * 
 */

use Livewire\Volt\Component;
use App\Models\UserContact;
use App\Models\Timezone;

new class extends Component {

    public UserContact $userContact;

    public $langCode;

    public $timezoneId;
    public $allTimezonesSet;

    public $address;
    public $addressLine2;
    public $city;
    public $region;
    public $postalCode;

    // mount() yes
    // render() no
    // with() no
    public function mount(UserContact $user_contact)
    {
        $this->userContact = $user_contact;
        // form fields
        $this->langCode = $user_contact->lang_code ?? 'it';
        $this->timezoneId = $user_contact->timezone_id ?? 'Europe/Rome';

        $this->address = $user_contact->address ?? 'N\A';
        $this->addressLine2 = $this->userContact->address_line2 ?? '';
        $this->city = $this->userContact->city ?? ''; //       municipality
        $this->region = $this->userContact->region ?? ''; //
        $this->postalCode = $this->userContact->postal_code ?? '';

        $this->allTimezonesSet = Timezone::all();
    }

    // validate rules
    public function rules(): array
    {
        return [
            'langCode'      => 'required|string|max:10',
            'address'       => 'required|string|max:255',
            'addressLine2'  => 'nullable|string|max:255',
            'city'          => 'required|string|max:100',
            'region'        => 'nullable|string|max:100',
            'postalCode'    => 'required|string|max:10',
            'timezoneId'    => 'required|string|exists:timezones,id',
        ];
    }

    public function updateUserContact2nd()
    {
        $validated = $this->validate();

        $this->userContact->lang_code = $validated['langCode'];
        $this->userContact->timezone_id = $validated['timezoneId'];
        $this->userContact->address = $validated['address'];
        $this->userContact->address_line2 = $validated['addressLine2'];
        $this->userContact->city = $validated['city'];
        $this->userContact->region = $validated['region'];
        $this->userContact->postal_code = $validated['postalCode'];

        $this->userContact->save();

        return redirect()
            ->route('user.contact.modify2', ['user_contact' => $this->userContact])
            ->with('success', __("Postal address updated successfully"));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your personal info / 2nd of five', ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="mb-4" />
        <livewire:user.contact.modify-nav :user_contact="$userContact" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />


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

                <form wire:submit="updateUserContact2nd">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="langCode" :value="__('Local lang code')" />
                        <x-text-input wire:model="langCode" id="langCode" name="langCode" class="block mt-1 w-48" type="text" required />
                        <x-input-error for="langCode" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="timezoneId" :value="__('Timezone')" />
                        <select 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            wire:model="timezoneId"
                            name="timezoneId" 
                            required
                            >
                            @foreach ($allTimezonesSet as $timezone_item)
                            <option value="{{ $timezone_item->id }}" {{ ($timezone_item->id == $timezoneId) ? 'selected' : '' }}> {{ $timezone_item->id }} </option>
                            @endforeach
                        </select>
                        <x-input-error for="timezoneId" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="address" :value="__('Address')" />
                        <x-text-input wire:model="address" id="address" class="block mt-1 w-full" type="text" name="address" required />
                        <x-input-error for="address" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="addressLine2" :value="__('Address 2nd line, facultative')" />
                        <x-text-input wire:model="addressLine2" id="addressLine2" name="addressLine2" type="text" class="block mt-1 w-full" />
                        <x-input-error for="addressLine2" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="city" :value="__('City')" />
                        <x-text-input wire:model="city" id="city" name="city" type="text" class="block mt-1 w-full" required />
                        <x-input-error for="city" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="region" :value="__('Region, State')" />
                        <x-text-input wire:model="region" id="region" name="region" type="text" class="block mt-1 w-full" required />
                        <x-input-error for="region" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="postalCode" :value="__('ZIP, Postal code')" />
                        <x-text-input wire:model="postalCode" id="postalCode" name="postalCode" type="text" class="block mt-1 w-full" required />
                        <x-input-error for="postalCode" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Update, then next panel') }}
                    </x-button>

                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
