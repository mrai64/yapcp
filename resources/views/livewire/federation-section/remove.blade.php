<?php
/**
 * Federation Section remove
 * only ask confirm, with data view as read only
 * 
 * 2026-06-12 refactor as volt-livewire 4
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
    'federationSection',
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
mount( function (FederationSection $federation_section) {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $this->federationSection = $federation_section;
    $this->federation = $federation_section->federation;
    $this->sectionCode = $federation_section->code;
    $this->sectionNameEn = $federation_section->name_en;
    $this->synopsis = $federation_section->synopsis; 
    $this->minWorks = $federation_section->min_works;
    $this->maxWorks = $federation_section->max_works;
    $this->shortSizeMax = $federation_section->short_size_max;
    $this->longSizeMax = $federation_section->long_size_max;
    $this->fileSizeMax = $federation_section->file_size_max;
    $this->monochromaticRequired = $federation_section->monochromatic_required;
    $this->rawRequired = $federation_section->raw_required;
    $this->uniquePrize = $federation_section->unique_prize;
});

// to validate
rules( function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    return [
        'sectionNameEn' => 'required|string|min:3|max:255',
        'synopsis' => 'required|string',
        'minWorks' => 'required|integer|min:0|max:20',
        'maxWorks' => 'required|integer|min:1|max:20',
        'shortSizeMax' => 'required|integer|min:1080|max:2500',
        'longSizeMax' => 'required|integer|min:1080|max:2500',
        'fileSizeMax' => 'required|integer|min:100000|max:6000000',
        'monochromaticRequired' => 'boolean', // maybe boolean:strict but... too much
        'rawRequired' => 'boolean',
        'uniquePrize' => 'boolean',
    ];

});

// to act
$removeFederationSection = function () {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationSection removed. Was: ' . json_encode($this->federationSection) );
    $this->federationSection->delete();

    // redirect
    return redirect()
        ->route('federation-section.list', ['federation' => $this->federation])
        ->with('success', __('Federation section updated, well done!'));

}; 

?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Remove Section :code of :federationName", ['code' => $federationSection->code, 'federationName' => $federationSection->federation->name_en]) }}
        </h2>
        <hr />
        <br />
        <p class="small">
            {{ __('LAST CALL. Are you SURE to delete that?')}}
            <br />
            {{ __('Maybe a contest running, or starting or recently ended, that make the remove harmful')}}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('federation-section.list', ['federation' => $federationSection->federation_id] ) }}"
                rel="noopener noreferrer">
                [ {{ __("Back to Federation Section list") }} ]
            </a>
        </p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <form wire:submit="removeFederationSection">
                @csrf

                <!-- federation-section code -->
                <div class="mb-4">
                    <x-input-label for="sectionCode" :value="__('Section Id, Code')" />
                    <x-text-input wire:model="sectionCode" id="sectionCode" class="block mt-1 w-48" type="text" name="sectionCode" readonly disabled />
                </div>
                <!--/federation-section code -->

                <!-- federation-section english name -->
                <div class="mb-4">
                    <x-input-label for="sectionNameEn" :value="__('Section name')" />
                    <x-text-input wire:model="sectionNameEn" id="sectionNameEn" class="block mt-1 w-full" type="text" name="sectionNameEn" required />
                </div>
                <!--/federation-section english name -->


                <!-- federation-section synopsis -->
                <div class="mb-4">
                    <x-input-label for="synopsis" :value="__('Section definition, Synopsis')" />
                    <x-text-input wire:model="synopsis" id="synopsis" class="block mt-1 w-full" type="text" name="synopsis" required  />
                </div>
                <!--/federation-section synopsis -->

                <!-- federation-section min works number-->
                <div class="mb-4">
                    <x-input-label for="minWorks" :value="__('Minimum works number for Section - from 0 to 20')" />
                    <x-text-input wire:model="minWorks" id="minWorks" class="block mt-1 w-48" type="number" name="minWorks" required  />
                </div>
                <!--/federation-section min works number-->

                <!-- federation-section max works number-->
                <div class="mb-4">
                    <x-input-label for="maxWorks" :value="__('Maximum works number for Section - from 1 to 20')" />
                    <x-text-input wire:model="maxWorks" id="maxWorks" class="block mt-1 w-48" type="number" name="maxWorks" required  />
                </div>
                <!--/federation-section max works number-->

                <!-- federation-section short side size px -->
                <div class="mb-4">
                    <x-input-label for="shortSizeMax" :value="__('Max size for shortest side - px')" />
                    <x-text-input wire:model="shortSizeMax" id="shortSizeMax" class="block mt-1 w-48" type="number" name="shortSizeMax" required  />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section long side size px -->
                <div class="mb-4">
                    <x-input-label for="longSizeMax" :value="__('Max size for longest side - px')" />
                    <x-text-input wire:model="longSizeMax" id="longSizeMax" class="block mt-1 w-48" type="number" name="longSizeMax" required  />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section file-size Bytes -->
                <div class="mb-4">
                    <x-input-label for="fileSizeMax" :value="__('Max size for file size - B')" />
                    <x-text-input wire:model="fileSizeMax" id="fileSizeMax" class="block mt-1 w-48" type="number" name="fileSizeMax" required  />
                </div>
                <!--/federation-section file-size Bytes -->

                <!-- federation-section Monochromatic Required On/Off -->
                <div class="mb-4">
                    <label for="monochromaticRequired" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="monochromaticRequired" id="monochromaticRequired" name="monochromaticRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Exclusively monochromatic images') }}
                    </label>
                </div>
                <!-- federation-section Monochromatic Required On/Off -->

                <!-- federation-section RAW maybe Required On/Off -->
                <div class="mb-4">
                    <label for="rawRequired" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="rawRequired" id="rawRequired" name="rawRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Original RAW should be required') }}
                    </label>
                </div>
                <!--/federation-section RAW maybe Required On/Off -->

                <!-- federation-section Cumulative prizes On/Off -->
                <div class="mb-4">
                    <label for="uniquePrize" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="uniquePrize" id="uniquePrize" name="uniquePrize" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Only A prize for author in section') }}
                    </label>
                </div>
                <!-- federation-section Cumulative prizes On/Off -->

                <p>&nbsp;</p>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                    >
                    {{ __('Confirm') }}
                </button>
            </form>
        </div>
    </div>
    <x-footer-app />
</div>
