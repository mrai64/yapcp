<?php 
/**
 * 2025-10-16 federations table refactored - now v.2
 *
 * @see /app/livewire/federation/modify.php
 */

?> 

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify few Federation infos') }}
        </h2>

        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ url('/docs') }}">
                [ {{ __("The Manual") }} ]
            </a>
        </div>
        . .
        @if (isset($federation))
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('federation-section.list', ['federation' => $federation])}}" 
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("Federation' Coded Sections List") }} 🗒️ ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a  href="{{ route('federation-more.list', ['federation' => $federation]) }}"
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("'Federation more' fields list") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a  href="{{ route('federation-more.add', ['federation' => $federation]) }}"
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("'Federation more' field add") }} ]
            </a>
        </div>
        . .
        @else
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="#" 
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("Federation' Coded Sections List") }} 🗒️ ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a  href="#"
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("'Federation more' fields list") }} ]
            </a>
        </div>
        . .
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a  href="#"
                target="_blank"
                rel="noopener noreferrer">
                [ {{ __("'Federation more' field add") }} ]
            </a>
        </div>
        . .
        @endif
        <div class="mb-4 fyk text-xl w-48 text-center inline-flex">
            <a href="{{ route('federation.list') }}">
                [ {{ __("Federation List") }} ]
            </a>
        </div>
        . .
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    <form wire:submit="updateFederation">
        @csrf 

        <div class="mb-4">
            <label for="federationId"
                class="block fyk font-medium text-xl text-gray-700" >
                {{ __('Federation Shortcode')}}
                | {{__('required')}}
                  {{__('unique')}}
            </label>
            <div class="suggest">{{__('Remember: must be a unique value in platform, uppercase letters, upto 10 chars')}}</div>
            <input
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48"
                type="text" name="federationId"
                wire:model.live.debounce.500ms="federationId" 
                value="{{ old('federationId') }}"
                required="required"
                />
            @error('federationId')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- federationId -->

        <div class="mb-4">
            <label for="federationNameEn"
                class="block fyk font-medium text-xl text-gray-700" >
                {{ __('Federation Name [en]') }}
                | {{__('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="federationNameEn"
                wire:model.live.debounce.500ms="federationNameEn" 
                value="{{ old('federationNameEn') }}"
                required="required" 
            />
            @error('federationNameEn')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- international federation name -->

        <div class="mb-4">
            <label for="website"
                class="block fyk font-medium text-xl text-gray-700" >
                {{__('Official website')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live="website" 
                type="text" name="website" 
                value="{{ old('website') }}"
                >
            @error('website')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- website -->

        <div class="mb-4">
            <label for="countryId"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" >
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
                <option value="{{ trim($country->id) }}" {{ ($country->id === $countryId ) ? 'selected' : '' }}> {{ $country->country }} </option>
            @endforeach
            </select>
            @error('countryId')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- country id -->

        <div class="mb-4">
            <label for="timezoneId"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" >
                {{ __('Timezone') }}
            </label>
            <div class="suggest">
                {{ __('As worldwide platform we need to manage correctly time.') }}
                {{ __('List is in alphabetically order A>Z') }}
            </div>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="timezoneId"
                name="timezoneId" 
                required="required"
                >
                @foreach ($timezoneSet as $timezone_item)
                <option value="{{ $timezone_item }}" {{ ($timezone_item == $timezoneId) ? 'selected' : '' }}> {{ $timezone_item }} </option>
                @endforeach
            </select>
            @error('timezoneId')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>


        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label for="federationContact"
                class="block fyk font-medium text-xl text-gray-700" >
                {{ __('Federation Contacts') }}
            </label>
            <div class="suggest">{{ __('HQ address, postal addess, email, international whatsapp number...') }}</div>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="federationContact"
                wire:model="federationContact"
                >{{ old('federationContact') }}</textarea>
            @error('federationContact')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div><!-- contact info -->
        <p>&nbsp;</p>
        <hr />
        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>
    </form>
        </div>
    </div>
</div>
