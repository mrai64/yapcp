<?php 

/**
 * User modify Organization
 *
 * @see /app/Livewire/Organization/Modify.php
 *
 */

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Organization infos') }}
        </h2>
        <p class="fyk text-xl font-medium mb-4">
            {{ __("Back to ")}}
            <a href="{{ route('organization.list') }}">
                [ {{__('Organization list')}} ]
            </a>
            . .
            {{ __("Back to ")}}
            <a href="{{ route('organization.dashboard', ['organization' => $id ]) }}">
                [ {{ __('Organization dashboard') }} ]
            </a>
        </p>
    </header>
    <form wire:submit="updateOrganization">
        @csrf

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                {{ __('Country') }}
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
            <div class="alert alert-danger small">@error('countryId') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label for="name"
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('name')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="text" name="name"
                wire:model.live.debounce.1000ms="name"
                required="required"
                />
            @error('name')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="email"
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('Secretary email')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="email" name="email"
                wire:model.live.debounce.1000ms="email"
                required="required"
                />
            @error('email')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="website"
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('Official website')}}
            </label>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full"
                type="url" name="website"
                wire:model.live.debounce.1000ms="website"
                required="required"
                placeholder="An https:// url"
                />
            @error('website')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contact">
                {{ __('Organization HQ and reference contact') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="contact"
                wire:model="contact"
            >{{ old('contact') }}</textarea>
            <div class="small">@error('contact') {{ $message }} @enderror</div>
        </div><!-- contact info -->

        <hr />

        <button type="submit"
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>

    </form>
</div>
