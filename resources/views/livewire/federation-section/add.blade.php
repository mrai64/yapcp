<?php

/**
 * Federation Section Add 
 * 
 * 2025-10-16 federations and federation_sections refactorize
 * 2026-06-10 refactor as volt-livewire 4
 * 
 */

use App\Models\Federation;
use App\Models\FederationSection;
use Illuminate\Support\Facades\Log;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;
use function Livewire\Volt\rules;

// state
state([
    'federation', // Federation input
    'sectionCode' => '', // default values in table
    'sectionNameEn' => '',
    'synopsis' => '',
    'minWorks' => 0,
    'maxWorks' => 4,
    'shortSizeMax' => 1080,
    'longSizeMax' => 1080,
    'fileSizeMax' => 100000,
    'monochromaticRequired' => false,
    'rawRequired' => false,
    'uniquePrize' => false,
]);

// to view
mount( function (Federation $federation) {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $this->federation = $federation;

});

// to validate
rules( function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    return [
        'sectionCode' => 'required|string|uppercase|min:2|max:10',
        'sectionNameEn' => 'required|string|min:3|max:255',
        'synopsis' => 'required|string',
        'minWorks' => 'required|integer|min:0|max:20',
        'maxWorks' => 'required|integer|min:1|max:20',
        'shortSizeMax' => 'required|integer|min:1080|max:2500',
        'longSizeMax' => 'required|integer|min:1080|max:2500',
        'fileSizeMax' => 'required|integer|min:100000|max:6000000',
        'monochromaticRequired' => 'boolean:strict',
        'rawRequired' => 'boolean:strict',
        'uniquePrize' => 'boolean:strict',
    ];

});

// to act

$saveNewFederationSection = function () {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $validate = $this->validate();
    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' validated:' . json_encode($validate));
    
    $federationSection = FederationSection::updateOrCreate(
        [
            'federation_id' => $this->federation->id,
            'code' => $validate['sectionCode'],
        ],
        [
            'name_en' => $validate['sectionNameEn'],
            'local_lang' => 'en',
            'local_name' => $validate['sectionNameEn'],
            'synopsis' => $validate['synopsis'],
            'file_formats' => 'jpg',
            'min_works' => $validate['minWorks'],
            'max_works' => $validate['maxWorks'],
            'short_size_max' => $validate['shortSizeMax'],
            'long_size_max' => $validate['longSizeMax'],
            'file_size_max' => $validate['fileSizeMax'],
            'monochromatic_required' => $validate['monochromaticRequired'],
            'raw_required' => $validate['rawRequired'],
            'unique_prize' => $validate['uniquePrize'],
        ]
    );

    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationSection:' . json_encode($federationSection) );
    // redirect
    return redirect()
        ->route('federation-section.list', ['federation' => $this->federation])
        ->with('success', __('New federation-section added, well done!'));

}; 

?> 


<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{__("New Section from Federation Contest Regulation")}} 
        </h2>
        <hr />
        <br />
        <p class="small">
            {{ __("The federation more field are required fields that interest only a federation adn not is a common field.") }}
            {{ __("I.e. the federation card id si a federation-more field, when surname not, it´s a common field.") }}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('federation-section.list', ['federation' => $federation] ) }}"
                rel="noopener noreferrer">
                [ {{ __("Back to Federation Section list") }} ]
            </a>
        </p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <form wire:submit="saveNewFederationSection">
                @csrf

                <!-- federation-section code -->
                <div class="mb-4">
                    <x-input-label for="sectionCode" :value="__('Section Id, Code')" />
                    <x-text-input wire:model="sectionCode" id="sectionCode" class="block mt-1 w-full" type="text" name="sectionCode" required placeholder="{{ __('Only uppercase chars, upto 10 chars') }}"/>
                    <x-input-error for="sectionCode" class="mt-2" />
                </div>
                <!--/federation-section code -->

                <!-- federation-section english name -->
                <div class="mb-4">
                    <x-input-label for="sectionNameEn" :value="__('Section name')" />
                    <x-text-input wire:model="sectionNameEn" id="sectionNameEn" class="block mt-1 w-full" type="text" name="sectionNameEn" required placeholder="{{ __('English name') }}"/>
                    <x-input-error for="sectionNameEn" class="mt-2" />
                </div>
                <!--/federation-section english name -->


                <!-- federation-section synopsis -->
                <div class="mb-4">
                    <x-input-label for="synopsis" :value="__('Section definition, Synopsis')" />
                    <x-text-input wire:model="synopsis" id="synopsis" class="block mt-1 w-full" type="text" name="synopsis" required placeholder="{{ __('From official docs, ev. translated in english text') }}" />
                    <x-input-error for="synopsis" class="mt-2" />
                </div>
                <!--/federation-section synopsis -->

                <!-- federation-section min works number-->
                <div class="mb-4">
                    <x-input-label for="minWorks" :value="__('Minimum works number for Section - from 0 to 20')" />
                    <x-text-input wire:model="minWorks" id="minWorks" class="block mt-1 w-full" type="number" name="minWorks" required placeholder="{{ __('Integer, from 0 to 20') }}" min="0" max="20" />
                    <x-input-error for="minWorks" class="mt-2" />
                </div>
                <!--/federation-section min works number-->

                <!-- federation-section max works number-->
                <div class="mb-4">
                    <x-input-label for="maxWorks" :value="__('Maximum works number for Section - from 1 to 20')" />
                    <x-text-input wire:model="maxWorks" id="maxWorks" class="block mt-1 w-full" type="number" name="maxWorks" required placeholder="{{ __('Integer, from 1 to 20') }}" min="0" max="20" />
                    <x-input-error for="maxWorks" class="mt-2" />
                </div>
                <!--/federation-section max works number-->

                <!-- federation-section short side size px -->
                <div class="mb-4">
                    <x-input-label for="shortSizeMax" :value="__('Max size for shortest side - px')" />
                    <x-text-input wire:model="shortSizeMax" id="shortSizeMax" class="block mt-1 w-full" type="number" name="shortSizeMax" required placeholder="{{ __('Integer, from 1 to 20') }}" min="1080" max="2500" />
                    <x-input-error for="shortSizeMax" class="mt-2" />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section long side size px -->
                <div class="mb-4">
                    <x-input-label for="longSizeMax" :value="__('Max size for longest side - px')" />
                    <x-text-input wire:model="longSizeMax" id="longSizeMax" class="block mt-1 w-full" type="number" name="longSizeMax" required placeholder="{{ __('Integer, from 1 to 20') }}" min="1080" max="2500" />
                    <x-input-error for="longSizeMax" class="mt-2" />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section file-size Bytes -->
                <div class="mb-4">
                    <x-input-label for="fileSizeMax" :value="__('Max size for file size - B')" />
                    <x-text-input wire:model="fileSizeMax" id="fileSizeMax" class="block mt-1 w-full" type="number" name="fileSizeMax" required placeholder="{{ __('Integer, from 100000     to 6000000') }}" min="100000" max="6000000" />
                    <x-input-error for="fileSizeMax" class="mt-2" />
                </div>
                <!--/federation-section file-size Bytes -->

                <!-- federation-section Monochromatic Required On/Off -->
                <div class="mb-4">
                    <label for="monochromaticRequired" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="monochromaticRequired" id="monochromaticRequired" name="monochromaticRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Exclusively monochromatic images') }}
                    </label>
                    <x-input-error for="monochromaticRequired" class="mt-2" />
                </div>
                <!-- federation-section Monochromatic Required On/Off -->

                <!-- federation-section RAW maybe Required On/Off -->
                <div class="mb-4">
                    <label for="rawRequired" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="rawRequired" id="rawRequired" name="rawRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Original RAW should be required') }}
                    </label>
                    <x-input-error for="rawRequired" class="mt-2" />
                </div>
                <!--/federation-section RAW maybe Required On/Off -->

                <!-- federation-section Cumulative prizes On/Off -->
                <div class="mb-4">
                    <label for="uniquePrize" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="uniquePrize" id="uniquePrize" name="uniquePrize" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Only A prize for author in section') }}
                    </label>
                    <x-input-error for="uniquePrize" class="mt-2" />
                </div>
                <!-- federation-section Cumulative prizes On/Off -->

                <p>&nbsp;</p>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                    >
                    {{ __('Add New') }}
                </button>
            </form>
        </div>
    </div>
    <x-footer-app />
</div>
