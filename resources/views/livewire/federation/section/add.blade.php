<?php 
/**
 * Federation Section Add 
 * 
 * 2025-10-16 federations and federation_sections refactorize
 * 
 * @see /app/Livewire/Federation/Section/Add.php
 * 
 */

?> 

<div>
    <header>
        <h1 class="fyk text-2xl font-medium text-gray-900">
            {{__("New Section from Federation Contest Regulation")}} 
        </h1>
        <p class="mb-4">
            <a href="{{ route('federation-section.list', ['federation' => $federation] ) }}"
                rel="noopener noreferrer">
            [ {{ __("Back to Federation Section list") }} ]
            </a>
        </p>
    </header>

    <form wire:submit="saveNewFederationSection">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="sectionCode">
                {{ __("Code for Section") }}
                | {{ __('required')}}
            </label>
            <div class="small">{{ __("Only uppercase chars, upto 10 chars.")}} </div>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="sectionCode"
                wire:model="sectionCode" 
                value="{{ old('sectionCode') }}"
                required="required" 
            />
            @error('sectionCode')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="sectionNameEn">
                {{ __("Section name [en]") }}
                | {{ __('required')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="sectionNameEn"
                wire:model="sectionNameEn" 
                value="{{ old('sectionNameEn') }}"
                required="required" 
            />
            @error('sectionNameEn')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="ruleDefinition">
                {{ __('Section definition') }}
                | {{ __('required')}}
            </label>
            <div class="small">{{ __("Explain official definition for that section from official docs, translated in english text")}} </div>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="ruleDefinition"
                wire:model="ruleDefinition"
            >{{ old('ruleDefinition') }}</textarea>
            @error('ruleDefinition')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="minWorks">
                {{ __("Min n. of works to participate") }}
                | {{ __('required')}}
            </label>
            <div class="small">{{ __("An integer between 0 and ...")}} </div>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="minWorks"
                wire:model="minWorks" 
                value="{{ old('minWorks') }}"
                required="required" 
            />
            @error('minWorks')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="maxWorks">
                {{ __("Max n. of works to participate") }}
                | {{ __('required')}}
            </label>
            <div class="small">{{ __("An integer between minWorks and ...")}} </div>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="maxWorks"
                wire:model="maxWorks" 
                value="{{ old('maxWorks') }}"
                required="required" 
            />
            @error('maxWorks')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add New') }}
        </button>
    </form>
</div>
