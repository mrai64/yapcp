<?php

/**
 * @see /app/Livewire/Organization/Add.php
 * 
 */

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('New Organization') }}
        </h2>
        <p class="fyk text-xl font-medium text-gray-900">
            {{__('The Organization is a photographic club or group of people or even an individual')}}
            {{__('who organize, and then manage photographic competitions,')}}
            {{__('optionally under the Patronage of one or more Federations.')}}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('organization.list') }}"
                rel="noopener noreferrer">
            [ {{ __('Back to Organization list') }} ]
            </a>
        </p>
    </header>
    <form wire:submit="saveNewOrganization">
        @csrf

        <div class="mb-4">
            <label for="name" 
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('Organization english name')}}
                | {{__('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="name" 
                wire:model="name"
                value="{{ old('name') }}"
                required="required"
                />
            @error('name')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                {{ __('Country') }}
                | {{__('required')}}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live="countryId"
                name="countryId" 
                required="required"
                >

                @foreach ($countries as $country)
                <option value="{{ trim($country->id) }}" {{ ($country->id === $countryId ) ? 'selected' : '' }}>{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('countryId') {{ $message }} @enderror</div>
        </div><!-- country id -->

        <div class="mb-4">
            <label for="email" 
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('Organization email')}}
                | {{__('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="email" name="email" 
                wire:model="email"
                value="{{ old('email') }}"
                required="required"
                />
            @error('email')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="organizationWebsite" 
                class="block mt-4 font-medium text-sm text-gray-700">
                {{__('Official organizationWebsite')}}
                | {{__('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="url" name="organizationWebsite" 
                wire:model="organizationWebsite"
                value="{{ old('organizationWebsite') }}"
                required="required"
                placeholder="An https:// url"
                />
            @error('organizationWebsite')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="organizationContact">
                {{ __('Organization Contacts') }}
            </label>
            <div class="small">{{__('HQ address, postal address, email, international whatsapp number...')}}</div>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="organizationContact"
                wire:model="organizationContact"
            >{{ old('organizationContact') }}</textarea>
            <div class="small">@error('organizationContact') {{ $message }} @enderror</div>
        </div><!-- contact info -->

        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add new Organization') }}
        </button>

    </form>
</div>
