<?php
/**
 * Federation Section Modify
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
    'federationSection',
    'federation', // Federation input
    'code' => '', // default values in table
    'name_en' => '',
    'synopsis' => '',
    'min_works' => 0,
    'max_works' => 4,
    'short_size_max' => 1080,
    'long_size_max' => 1080,
    'file_size_max' => 100000,
    'monochromatic_required' => false,
    'raw_required' => false,
    'unique_prize' => false,
]);

// to view
mount( function (FederationSection $federation_section) {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $this->federationSection = $federation_section;
    $this->federation = $federation_section->federation;
    $this->code = $federation_section->code;
    $this->name_en = $federation_section->name_en;
    $this->synopsis = $federation_section->synopsis; 
    $this->min_works = $federation_section->min_works;
    $this->max_works = $federation_section->max_works;
    $this->short_size_max = $federation_section->short_size_max;
    $this->long_size_max = $federation_section->long_size_max;
    $this->file_size_max = $federation_section->file_size_max;
    $this->monochromatic_required = $federation_section->monochromatic_required;
    $this->raw_required = $federation_section->raw_required;
    $this->unique_prize = $federation_section->unique_prize;
});

// to validate
rules( function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    return [
        'name_en' => 'required|string|min:3|max:255',
        'synopsis' => 'required|string',
        'min_works' => 'required|integer|min:0|max:20',
        'max_works' => 'required|integer|min:1|max:20',
        'short_size_max' => 'required|integer|min:1080|max:2500',
        'long_size_max' => 'required|integer|min:1080|max:2500',
        'file_size_max' => 'required|integer|min:100000|max:6000000',
        'monochromatic_required' => 'boolean', 
        'raw_required' => 'boolean',
        'unique_prize' => 'boolean',
    ];

});

// to act
$modifyFederationSection = function () {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $validate = $this->validate();
    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' validated:' . json_encode($validate));
    
    $this->federationSection->update([
        'name_en' => $validate['name_en'],
        'local_lang' => 'en',
        'local_name' => $validate['name_en'],
        'synopsis' => $validate['synopsis'],
        'file_formats' => 'jpg',
        'min_works' => $validate['min_works'],
        'max_works' => $validate['max_works'],
        'short_size_max' => $validate['short_size_max'],
        'long_size_max' => $validate['long_size_max'],
        'file_size_max' => $validate['file_size_max'],
        'monochromatic_required' => $validate['monochromatic_required'],
        'raw_required' => $validate['raw_required'],
        'unique_prize' => $validate['unique_prize'],
    ]);

    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationSection updated' );
    // redirect
    return redirect()
        ->route('federation-section.list', ['federation' => $this->federation])
        ->with('success', __('Federation section updated, well done!'));

}; 

?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Modify Section :code of :federationName", ['code' => $federationSection->code, 'federationName' => $federationSection->federation->name_en]) }}
        </h2>
        <hr />
        <br />
        <p class="small">
            {{ __("The federation more field are required fields that interest only a federation adn not is a common field.") }}
            {{ __("I.e. the federation card id si a federation-more field, when surname not, it´s a common field.") }}
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

            <form wire:submit="modifyFederationSection">
                @csrf

                <!-- federation-section code -->
                <div class="mb-4">
                    <x-input-label for="code" :value="__('Section Id, Code')" />
                    <x-text-input wire:model="code" id="code" class="block mt-1 w-48" type="text" name="code" readonly disabled />
                </div>
                <!--/federation-section code -->

                <!-- federation-section english name -->
                <div class="mb-4">
                    <x-input-label for="name_en" :value="__('Section name')" />
                    <x-text-input wire:model="name_en" id="name_en" class="block mt-1 w-full" type="text" name="name_en" required placeholder="{{ __('English name') }}"/>
                    <x-input-error for="name_en" class="mt-2" />
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
                    <x-input-label for="min_works" :value="__('Minimum works number for Section - from 0 to 20')" />
                    <x-text-input wire:model="min_works" id="min_works" class="block mt-1 w-48" type="number" name="min_works" required placeholder="{{ __('Integer, from 0 to 20') }}" min="0" max="20" />
                    <x-input-error for="min_works" class="mt-2" />
                </div>
                <!--/federation-section min works number-->

                <!-- federation-section max works number-->
                <div class="mb-4">
                    <x-input-label for="max_works" :value="__('Maximum works number for Section - from 1 to 20')" />
                    <x-text-input wire:model="max_works" id="max_works" class="block mt-1 w-48" type="number" name="max_works" required placeholder="{{ __('Integer, from 1 to 20') }}" min="0" max="20" />
                    <x-input-error for="max_works" class="mt-2" />
                </div>
                <!--/federation-section max works number-->

                <!-- federation-section short side size px -->
                <div class="mb-4">
                    <x-input-label for="short_size_max" :value="__('Max size for shortest side - px')" />
                    <x-text-input wire:model="short_size_max" id="short_size_max" class="block mt-1 w-48" type="number" name="short_size_max" required placeholder="{{ __('Integer, from 1 to 20') }}" min="1080" max="2500" />
                    <x-input-error for="short_size_max" class="mt-2" />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section long side size px -->
                <div class="mb-4">
                    <x-input-label for="long_size_max" :value="__('Max size for longest side - px')" />
                    <x-text-input wire:model="long_size_max" id="long_size_max" class="block mt-1 w-48" type="number" name="long_size_max" required placeholder="{{ __('Integer, from 1 to 20') }}" min="1080" max="2500" />
                    <x-input-error for="long_size_max" class="mt-2" />
                </div>
                <!-- federation-section short side size px -->

                <!-- federation-section file-size Bytes -->
                <div class="mb-4">
                    <x-input-label for="file_size_max" :value="__('Max size for file size - B')" />
                    <x-text-input wire:model="file_size_max" id="file_size_max" class="block mt-1 w-48" type="number" name="file_size_max" required placeholder="{{ __('Integer, from 100000     to 6000000') }}" min="100000" max="6000000" />
                    <x-input-error for="file_size_max" class="mt-2" />
                </div>
                <!--/federation-section file-size Bytes -->

                <!-- federation-section Monochromatic Required On/Off -->
                <div class="mb-4">
                    <label for="monochromatic_required" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="monochromatic_required" id="monochromatic_required" name="monochromatic_required" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Exclusively monochromatic images') }}
                    </label>
                    <x-input-error for="monochromatic_required" class="mt-2" />
                </div>
                <!-- federation-section Monochromatic Required On/Off -->

                <!-- federation-section RAW maybe Required On/Off -->
                <div class="mb-4">
                    <label for="raw_required" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="raw_required" id="raw_required" name="raw_required" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Original RAW should be required') }}
                    </label>
                    <x-input-error for="raw_required" class="mt-2" />
                </div>
                <!--/federation-section RAW maybe Required On/Off -->

                <!-- federation-section Cumulative prizes On/Off -->
                <div class="mb-4">
                    <label for="unique_prize" class="ms-2 text-sm text-gray-600">
                        <x-checkbox wire:model="unique_prize" id="unique_prize" name="unique_prize" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                        {{ __('Only A prize for author in section') }}
                    </label>
                    <x-input-error for="unique_prize" class="mt-2" />
                </div>
                <!-- federation-section Cumulative prizes On/Off -->

                <p>&nbsp;</p>
                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                    >
                    {{ __('Modify') }}
                </button>
            </form>
        </div>
    </div>
    <x-footer-app />
</div>
