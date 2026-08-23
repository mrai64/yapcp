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
use Illuminate\Support\Facades\Auth;
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
        Log::info('User admin ['. Auth::user()->id . ' ' . Auth::user()->name
            . '] request remove of federation: '
            . json_encode($this->federationSection));
    $this->federationSection->delete();

    // redirect
    return redirect()
        ->route('federation-section.listed', ['federation' => $this->federation])
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
            <a href="{{ route('federation-section.listed', ['federation' => $federationSection->federation_id] ) }}"
            rel="noopener noreferrer">
            [ {{ __("Back to Federation Section list") }} ]
        </a>
    </p>
</x-slot>
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-500 hover:border-indigo-300 transition-colors relative">
            <div class="fyk text-2xl font-bold text-indigo-700">
                {{ $this->federationSection->code }}
                _
                {{ $this->federationSection->name_en }}
            </div>

            <div class="px-5 mt-2">
                {{ __('Synopsis') }}
                <br />
                {{ $this->federationSection->synopsis ?? 'N\A' }}
                <br />
            </div>

            <div class="px-5">
                {{ __('Min / max # works') }}: 
                {{ __('min') }}: {{ $this->federationSection->min_works }}
                {{ __('to')  }}
                {{ __('max') }}: {{ $this->federationSection->max_works }}
            </div>
            
            <div class="px-5">
                {{ __('Max px') }}: 
                {{ __(':shortsize for short side, and :longsize for long side', ['shortsize' => $this->federationSection->short_size_max, 'longsize' => $this->federationSection->long_size_max, ] ) }}
            </div>
            
            <div class="px-5">
                {{ $this->federationSection->monochromatic_required ? '✅ YES' : '❌ NO' }}
                | 
                {{ __('Monochrome only') }}
            </div>
            
            <div class="px-5">
                {{ $this->federationSection->raw_required ? '✅ YES' : '❌ NO' }}
                | 
                {{ __('RAW when asked') }}
            </div>

            <div class="px-5">
                {{ $this->federationSection->unique_prize ? '✅ YES' : '❌ NO' }}
                | 
                {{ __('Only a prize per author per section') }} 
            </div>

            <form wire:submit="removeFederationSection">
                @csrf

                <x-button class="mt-2 ms-4">
                    {{ __('LAST CALL. Are you SURE to delete that?') }}
                </x-button>
            </form>
        </div>
    </div>
    <x-footer-app />
</div>

