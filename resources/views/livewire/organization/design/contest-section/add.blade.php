<?php

/**
 * Organization Contest design / Add a ContestSection record
 *
 * "version 1" - no version 1
 * "version 2" - add federation_sections
 */

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\Federation;
use App\Models\FederationSection;
use App\Models\Organization;
use App\Rules\ValidFileFormats;
use Livewire\Attributes\Computed;
use Livewire\Volt\Component;

new class extends Component {
    
    public Contest $contest;
    public Federation $federation;
    public ContestSection $contestSection;
    public FederationSection $federationSectionsSet;
    public Organization $organization;
    // form fields
    public string $contestSectionFederationId; // contest_sections.federation_id
    public string $contestSectionCode; // contest_sections.code
    public bool   $contestSectionUnderPatronage;
    public int    $contestSectionFederationSectionId;
    public string $contestSectionNameEn;
    public string $contestSectionNameLocal;
    public string $contestSectionSynopsis;
    public string $contestSectionFileFormats;
    public string $contestSectionMinWorks;
    public string $contestSectionMaxWorks;
    public string $contestSectionShortSizeMax;
    public string $contestSectionLongSizeMax;
    public string $contestSectionFileSizeMax;
    public string $contestSectionMonochromaticRequired;
    public string $contestSectionRawRequired;
    public string $contestSectionUniquePrize;
    // used in separated form
    public ?string $selectedFederationId = null;
    public ?string $selectedSectionCode = null;

    // reset prima select
    // viene richiamata all'updated della proprietà
    public function updatedSelectedFederationId(): void
    {
        $this->selectedSectionCode = null;
        if ($this->selectedFederationId) {
            $this->contestSectionFederationId = $this->selectedFederationId;
        } else {
            $this->selectedFederationId = '';
        }
    }
    // viene richiamata all'updated della proprietà
    public function updatedSelectedSectionCode(): bool
    {
        if (!$this->selectedFederationId || !$this->selectedSectionCode) {
            return false;
        }

        // cambia i valori della section a form
        $federationSection = FederationSection::where('federation_id', $this->selectedFederationId)
            ->where('code', $this->selectedSectionCode)
            ->first();
        
        $this->contestSectionFederationId = $federationSection->federation_id;
        $this->contestSectionFederationSectionId = $federationSection->id;
        $this->contestSectionCode = $federationSection->code;
        $this->contestSectionNameEn = $federationSection->name_en;
        // $this->contestSectionLocalLang = ...;
        $this->contestSectionSynopsis = $federationSection->synopsis ?? '';
        $this->contestSectionFileFormats = $federationSection->file_formats;
        $this->contestSectionMinWorks = $federationSection->min_works;
        $this->contestSectionMaxWorks = $federationSection->max_works;
        $this->contestSectionShortSizeMax = $federationSection->short_size_max;
        $this->contestSectionLongSizeMax = $federationSection->long_size_max;
        $this->contestSectionFileSizeMax = $federationSection->file_size_max;
        $this->contestSectionMonochromaticRequired = $federationSection->monochromatic_required;
        $this->contestSectionRawRequired = $federationSection->raw_required;
        $this->contestSectionUniquePrize = $federationSection->unique_prize;

        return true;
    }

    // la lista delle Federaton
    #[Computed]
    public function getFederationsSet()
    {
        return Federation::orderBy('id')->get();
    }

    // la lista delle section
    #[Computed]
    public function getFederationSectionSet()
    {
        if (!$this->selectedFederationId) {
            return collect();
        }
        return FederationSection::where('federation_id', $this->selectedFederationId)
            ->orderBy('name_en')
            ->get();
    }


    public function mount(Contest $contest)
    {
        $this->contest = $contest;
        $this->organization = $contest->organization;
        $this->contestSectionUnderPatronage = false;
        $this->contestSectionMonochromaticRequired = false;
        $this->contestSectionRawRequired = false;
        $this->contestSectionUniquePrize = false;
    }

    public function rules()
    {
        return [
            'contestSectionFederationId'   => 'nullable|string|uppercase|exists:federations,id',
            'contestSectionCode'           => 'required|string|uppercase',
            'contestSectionUnderPatronage' => 'nullable|boolean',
            'contestSectionFederationSectionId' => 'nullable|exists:federation_sections,id',
            'contestSectionNameEn' => 'required|string|max:250',
            'contestSectionNameLocal' => 'nullable|string|max:250',
            'contestSectionSynopsis' => 'nullable|string|max:2000',
            'contestSectionFileFormats' => [
                'required',
                'string',
                'lowercase',
                new ValidFileFormats(),
            ],
            'contestSectionMinWorks' => 'required|integer|min:0|max:12',
            'contestSectionMaxWorks' => 'required|integer|max:12|gte:contestSectionMinWorks',
            'contestSectionShortSizeMax' => 'required|integer|min:2|max:4000',
            'contestSectionLongSizeMax' => 'required|integer|max:4000|gte:contestSectionShortSizeMax',
            'contestSectionFileSizeMax' => 'required|integer|min:100000|max:6000000',
            'contestSectionMonochromaticRequired' => 'nullable|boolean',
            'contestSectionRawRequired' => 'nullable|boolean',
            'contestSectionUniquePrize' => 'nullable|boolean',
        ];
    }

    public function addContestSection()
    {
        $validated = $this->validate();

        $contestSection = ContestSection::updateOrCreate([
            'contest_id' => $this->contest->id,
            'code'       => $validated['contestSectionCode'],
        ], [
            'under_patronage' => $validated['contestSectionUnderPatronage'] ?? false,
            'federation_section_id' => $validated['contestSectionFederationSectionId'],
            'name_en' => $validated['contestSectionNameEn'],
            'name_local' => $validated['contestSectionNameLocal'],
            'synopsis' => $validated['contestSectionSynopsis'],
            'file_formats' => $validated['contestSectionFileFormats'],
            'min_works' => $validated['contestSectionMinWorks'],
            'max_works' => $validated['contestSectionMaxWorks'],
            'short_size_max' => $validated['contestSectionShortSizeMax'],
            'long_size_max' => $validated['contestSectionLongSizeMax'],
            'file_size_max' => $validated['contestSectionFileSizeMax'],
            'monochromatic_required' => $validated['contestSectionMonochromaticRequired'],
            'raw_required'           => $validated['contestSectionRawRequired'],
            'unique_prize'           => $validated['contestSectionUniquePrize'],
        ]);

        // redirect itself
        return redirect()
            ->route('organization.design.contest-section.add', ['contest' => $this->contest ])
            ->with('success', __('New Section added to contest, enjoy!'));

    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Contest infos') }}
        </h2>
        <hr class="mb-4" />
        <livewire:organization.design.contest.modify-nav :contest="$contest" />
        <hr class="mb-2" />
        <livewire:organization.design.contest-nav :contest="$contest" />
        <hr class="mb-2" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-header-link-app 
			txt="Organization dashboard" 
            url="{{ route('organization.dashboard', ['organization' => $organization]) }}" />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                <hr />
                @endif

                <!-- errors list -->
                @if ($errors->any())
                <br />
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                <br />
                @endif

                <h3 class="fyk text-2xl font-medium text-gray-900">
                    {{ __('Contest Section n theme') }}
                </h3>
                <hr class="mb-4" />
                <form wire:submit="addContestSection">
                    @csrf

                    <!-- Under Patronage -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionUnderPatronage" :value="__('That section is...')" />
                            <x-checkbox wire:model.live="contestSectionUnderPatronage" id="contestSectionUnderPatronage" name="contestSectionUnderPatronage" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Under a federation patronage') }}
                        </label>
                        <x-input-error for="contestSectionUnderPatronage" class="mt-2" />
                    </div>
                    <!--/Under Patronage -->
                    
                    @if ($contestSectionUnderPatronage)
                    <div>
                        
                        <h3 class="fyk text-2xl font-medium text-gray-900">
                            {{ __('Under patronage, easy choice from FederationSections') }}
                        </h3>
                            <select wire:model.live="selectedFederationId"
                                class="mb-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" >
                                <option value="">{{ __('Choose a Federation') }}</option>
                                @foreach($this->getFederationsSet as $fed)
                                <option value="{{ $fed->id }}">{{ $fed->id }} {{ $fed->name_en }}</option>
                                @endforeach
                            </select>
                            
                            <select wire:model.live="selectedSectionCode" 
                                class="mb-4 border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                                @disabled(!$this->selectedFederationId)>
                                <option class="font-mono" value="">
                                    {{ $this->selectedFederationId ? __('Select a Section') : __('No sections. Before, select a Federation') }}
                                </option>
                                
                                @foreach($this->getFederationSectionSet as $section)
                                <option class="font-mono" value="{{ $section->code }}">{{ $section->code }} - {{ $section->name_en }}</option>
                                @endforeach
                            </select>
                    </div>
                    @else
                    <div>
                        <h3 class="fyk text-2xl font-medium text-gray-900">
                            {{ __('Free from Federations sections grid') }}
                        </h3>
                    </div>
                    @endif

                    <!-- contestSectionFederationId -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionFederationId" :value="__('Federation Id')" />
                        <x-text-input wire:model="contestSectionFederationId" id="contestSectionFederationId" 
                            class="block mt-1 w-60" type="text" readonly />
                        <p class="text-sm">{{ __('For info only') }}</p>
                        <x-input-error for="contestSectionFederationId" class="mt-2" />
                    </div>

                    <!-- contestSectionFederationSectionId -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionFederationSectionId" :value="__('Federation Section Code')" />
                        <x-text-input wire:model="contestSectionFederationSectionId" id="contestSectionFederationSectionId" 
                            class="block mt-1 w-48" type="text" readonly />
                        <p class="text-sm">{{ __('For info only') }}</p>
                        <x-input-error for="contestSectionFederationSectionId" class="mt-2" />
                    </div>

                    <!-- contestSectionCode -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionCode" :value="__('Section Code')" />
                        <x-text-input wire:model="contestSectionCode" id="contestSectionCode" name="contestSectionCode" 
                            class="block mt-1 w-48" type="text" required />
                        <p class="text-sm">{{ __("Only uppercase chars, upto 10 chars") }}</p>
                        <x-input-error for="contestSectionCode" class="mt-2" />
                    </div>

                    <!-- contestSectionNameEn -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionNameEn" :value="__('Section name, english')" />
                        <x-text-input wire:model="contestSectionNameEn" id="contestSectionNameEn" name="contestSectionNameEn" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="contestSectionNameEn" class="mt-2" />
                    </div>

                    <!-- contestSectionNameLocal -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionNameLocal" :value="__('Section name, local lang')" />
                        <x-text-input wire:model="contestSectionNameLocal" id="contestSectionNameLocal" name="contestSectionNameLocal" 
                            class="block mt-1 w-full" type="text" />
                        <x-input-error for="contestSectionNameLocal" class="mt-2" />
                    </div>

                    <!-- contestSectionSynopsis -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="contestSectionSynopsis" :value="__('Synopsis - Section definition, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="contestSectionSynopsis"
                        wire:model="contestSectionSynopsis"
                        >{{ old('contestSectionSynopsis') }}</textarea>
                        <x-input-error for="contestSectionSynopsis" class="mt-2" />
                    </div>

                    <!-- contestSectionFileFormat -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionFileFormats" :value="__('File extension List, english')" />
                        <x-text-input wire:model="contestSectionFileFormats" id="contestSectionFileFormats" name="contestSectionFileFormats" 
                            class="block mt-1 w-full" type="text" required />
                        <p class="text-sm">{{ __('Almost a file extension, comma separated i.e.: jpg,jpeg,tif') }}</p>
                        <p class="text-sm">✅ {{ implode(', ', config('app-yapcp.formats.allowed')) }} </p>
                        <x-input-error for="contestSectionFileFormats" class="mt-2" />
                    </div>

                    <!-- contestSectionMinWorks -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionMinWorks" :value="__('Min number of works for section')" />
                        <x-text-input wire:model="contestSectionMinWorks" id="contestSectionMinWorks" 
                            class="block mt-1 w-48" type="number" name="contestSectionMinWorks" required 
                            min="0" max="12" />
                        <p class="text-sm">{{ __('Between 0 and 12, included') }}</p>
                        <x-input-error for="contestSectionMinWorks" class="mt-2" />
                    </div>
                    <!--/contestSectionMinWorks -->

                    <!-- contestSectionMaxWorks -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionMaxWorks" :value="__('Max works for section')" />
                        <x-text-input wire:model="contestSectionMaxWorks" id="contestSectionMaxWorks" 
                            class="block mt-1 w-48" type="number" name="contestSectionMaxWorks" required 
                            min="0" max="12" />
                        <p class="text-sm">{{ __('Between 0 and 12, included. Not less min works.') }}</p>
                        <x-input-error for="contestSectionMaxWorks" class="mt-2" />
                    </div>
                    <!--/contestSectionMaxWorks -->

                    <!-- contestSectionShortSizeMax -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionShortSizeMax" :value="__('Max size of shortest side image - px')" />
                        <x-text-input wire:model="contestSectionShortSizeMax" id="contestSectionShortSizeMax" 
                            class="block mt-1 w-48" type="number" name="contestSectionShortSizeMax" required 
                            min="1000" max="4000" />
                        <p class="text-sm">{{ __('Between 1000 and 4000, included') }}</p>
                        <x-input-error for="contestSectionShortSizeMax" class="mt-2" />
                    </div>
                    <!--/contestSectionShortSizeMax -->

                    <!-- contestSectionLongSizeMax -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionLongSizeMax" :value="__('Max size of longest side image - px')" />
                        <x-text-input wire:model="contestSectionLongSizeMax" id="contestSectionLongSizeMax" 
                            class="block mt-1 w-48" type="number" name="contestSectionLongSizeMax" required 
                            min="1000" max="4000" />
                        <p class="text-sm">{{ __('Between 1000 and 4000, included') }}</p>
                        <x-input-error for="contestSectionLongSizeMax" class="mt-2" />
                    </div>
                    <!--/contestSectionLongSizeMax -->

                    <!-- contestSectionFileSizeMax -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionFileSizeMax" :value="__('Max size of file - B')" />
                        <x-text-input wire:model="contestSectionFileSizeMax" id="contestSectionFileSizeMax" 
                            class="block mt-1 w-60" type="number" name="contestSectionFileSizeMax" required 
                            min="100000" max="6000000" />
                        <p class="text-sm">{{ __('Between 100000 and 6000000, included') }}</p>
                        <x-input-error for="contestSectionFileSizeMax" class="mt-2" />
                    </div>
                    <!--/contestSectionFileSizeMax -->


                    <!-- Monochromatic required  -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionMonochromaticRequired" :value="__('Monochromatic required')" />
                            <x-checkbox wire:model="contestSectionMonochromaticRequired" id="contestSectionMonochromaticRequired" name="contestSectionMonochromaticRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes: monochromatic(*), not coloured') }}
                        </label>
                        <p class="text-sm">
                            (*)&nbsp;
                            {{ __('Warning: for some federation monochromatic is not exclusively white-to-black, but should be also one-color-to-black') }}
                        </p>
                        <x-input-error for="contestSectionMonochromaticRequired" class="mt-2" />
                    </div>
                    <!--/Monochromatic required -->

                    <!-- RAW required  -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionRawRequired" :value="__('RAW required')" />
                            <x-checkbox wire:model="contestSectionRawRequired" id="contestSectionRawRequired" name="contestSectionRawRequired" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes, for that section RAW should be required') }}
                        </label>
                        <p class="text-sm">{{ __('For some federation, and for some section participant may demonstrate the original RAW or more RAW to Organization and or Federation inquiry members') }}</p>
                        <x-input-error for="contestSectionRawRequired" class="mt-2" />
                    </div>
                    <!--/RAW required -->

                    <!-- Only one prize or not  -->
                    <div class="mb-4">
                        <x-input-label for="contestSectionUniquePrize" :value="__('Unique prize for section')" />
                            <x-checkbox wire:model="contestSectionUniquePrize" id="contestSectionUniquePrize" name="contestSectionUniquePrize" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Yes, only a prize per participant per section') }}
                        </label>
                        <x-input-error for="contestSectionUniquePrize" class="mt-2" />
                    </div>
                    <!--/RAW required -->

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Check all, then Modify') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
