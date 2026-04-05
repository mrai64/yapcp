<?php 
/**
 * 2025-10-16 federations table refactored - now v.2
 *
 * @see /app/livewire/federation/modify.php
 */

?> 

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify few Federation infos') }}
        </h2>
    <hr />
    <br />
    <p class="mb-4">
        <a href="{{ route('federation-section.list', ['federation' => $federation])}}" 
            class="fyk text-xl mb-4"
            target="_blank" rel="noopener noreferrer"
            >
        Federation' Coded Sections List 🗒️
        </a>
    </p><!-- federation section list -->

        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('federation.list') }}"
                rel="noopener noreferrer">
            [ {{ __('Back to Federation list') }} ]
            </a>
        </p>
    </header>
    <form wire:submit="updateFederation">
        @csrf 

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federationId">
                {{ __('Federation Shortcode')}}
                | {{__('required')}}
                  {{__('unique')}}
            </label>
            <div class="small">{{__('Remember: must be a unique value in platform, uppercase letters, upto 10 chars')}}</div>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                type="text" name="federationId"
                wire:model.live.debounce.500ms="federationId" 
                value="{{ old('federationId') }}"
                required="required"
                />
            <div class="small">@error('federationId') {{ $message }} @enderror</div>
        </div><!-- federationId -->

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="federationNameEn">
                {{ __('Federation Name [en]') }}
                | {{__('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="federationNameEn"
                wire:model.live.debounce.500ms="federationNameEn" 
                required="required" 
            />
            @error('federationNameEn')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- international federation name -->

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{__('Official website')}}
            </label>
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            wire:model.live="website" 
            type="text" name="website" 
            value="{{ old('website') }}"
            >
            <div class="alert alert-danger small">@error('website') {{ __($message) }} @enderror</div>
        </div><!-- website -->

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
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="federationContact">
                {{ __('Federation Contacts') }}
            </label>
            <div class="small">{{__('HQ address, postal addess, email, international whatsapp number...')}}</div>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="federationContact"
                wire:model="federationContact"
            >{{ old('federationContact') }}</textarea>
            <div class="small">@error('federationContact') {{ $message }} @enderror</div>
        </div><!-- contact info -->

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>
    </form>

</div>
