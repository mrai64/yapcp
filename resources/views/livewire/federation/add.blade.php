<?php

/**
 * Federation Add by admin
 *
 */

use App\Models\Federation;
use Livewire\Volt\Component;


new class () extends Component {
    public Federation $federation;

    public string $federationId;
    public string $federationCountryId;
    public string $federationNameEn;
    public string $federationWebsite;
    public string $federationContactInfo;
    public string $federationLocalLang;
    public string $federationNameLocal;
    public string $federationTimezoneId;

    // mount() yes
    // with() no
    public function mount()
    {
        $this->federationId        = '';
        $this->federationCountryId = '';
        $this->federationNameEn = '';
        $this->federationWebsite = '';
        $this->federationContactInfo = '';
        $this->federationLocalLang = '';
        $this->federationNameLocal = '';
        $this->federationTimezoneId = '';
    }

    public function rules(): array
    {
        return [
            'federationId'          => 'required|string|uppercase|min:2|max:10|unique:federations,id',
            'federationCountryId'   => 'required|string|uppercase|min:3|exists:countries,id',
            'federationNameEn'      => 'required|string|min:3|max:255',
            'federationWebsite'     => 'string|active_url|max:255',
            'federationContactInfo' => 'required|string|max:2000',
            'federationLocalLang'   => 'string|max:6',
            'federationNameLocal'   => 'string|min:3|max:255',
            'federationTimezoneId'  => 'required|exists:timezones,id',
        ];
    }

    public function addFederation()
    {
        $validated = $this->validate();

        Federation::updateOrCreate(
            [
                'id' => $validated['federationId'],
            ],
            [
                'country_id'   => $validated['federationCountryId'],
                'name_en'      => $validated['federationNameEn'],
                'website'      => $validated['federationWebsite'],
                'local_lang'   => $validated['federationLocalLang'],
                'name_local'   => $validated['federationNameLocal'],
                'timezone_id'  => $validated['federationTimezoneId'],
                'contact_info' => $validated['federationContactInfo'],
            ]
        );

        return redirect()
            ->route('federation.listed')
            ->with('success', __("New federations was added successfully"));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Add a new Fed') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.header-link 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Federation list" 
			url="{{ route('federation.listed') }}" />
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- success -->
                @if (session('success'))
                <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
                    {{ session('success') }}
                </div>
                @endif
                
                <!-- errors list -->
                @if ($errors->any())
                <div>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                
                <form wire:submit="addFederation">
                    @csrf
                    
                    <!-- federationId -->
                    <div class="mb-4">
                        <x-input-label for="federationId" :value="__('Federation ID')" />
                        <x-text-input wire:model="federationId" id="federationId" name="federationId" class="block mt-1 w-full" type="text" required />
                        <p class="small">{{ __('Uppercase acronym, if there is already the same acronym for another federation in list, use country code as prefix, i.e. ARG:FAF, AND:FAF') }}</p>
                        <x-input-error for="federationId" class="mt-2" />
                    </div>

                    <!-- country select -->
                    <x-select-country-app wire:model="federationCountryId" :country_id="$federationCountryId" /> 

                    <!-- federationNameEn -->
                    <div class="mb-4">
                        <x-input-label for="federationNameEn" :value="__('Federation Name, english')" />
                        <x-text-input wire:model="federationNameEn" id="federationNameEn" name="federationNameEn" class="block mt-1 w-full" type="text" required />
                        <x-input-error for="federationNameEn" class="mt-2" />
                    </div>

                    <!-- federationWebsite -->
                    <div class="mb-4">
                        <x-input-label for="federationWebsite" :value="__('Official website')" />
                        <x-text-input wire:model="federationWebsite" id="federationWebsite" name="federationWebsite" class="block mt-1 w-full" type="url" required />
                        <x-input-error for="federationWebsite" class="mt-2" />
                    </div>

                    <!-- federationLocalLang -->
                    <div class="mb-4">
                        <x-input-label for="federationLocalLang" :value="__('Local lang code')" />
                        <x-text-input wire:model="federationLocalLang" id="federationLocalLang" name="federationNameEn" class="block mt-1 w-full" type="text" required />
                        <x-input-error for="federationLocalLang" class="mt-2" />
                    </div>
                    
                    <!-- timezone select -->
                    <x-select-timezone-app wire:model="federationTimezoneId" :country_id="$federationTimezoneId" /> 

                    <!-- federationContactInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="federationContactInfo" :value="__('Contact info, HQ postal address, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="federationContactInfo"
                        wire:model="federationContactInfo"
                        >{{ old('federationContactInfo') }}</textarea>
                        <x-input-error for="federationContactInfo" class="mt-2" />
                    </div>
                    
                    
                    <br style="clear:both;" />
                    
                    <x-button class="mt-2 ms-4">
                        {{ __('Check all, then Add') }}
                    </x-button>
                </form>
                
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
