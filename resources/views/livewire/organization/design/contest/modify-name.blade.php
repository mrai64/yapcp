<?php

/**
 * Organization Contest Design 1 / name and other infos
 * 
 */

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component {
    public Contest $contest;
    public Organization $organization;
    public UserContact $creator;
    public string  $contestNameEn;
    public string  $contestCountryId;
    public string  $contestTimezoneId;
    public string  $contestLangLocal;
    public string  $contestNameLocal;
    public bool    $contestIsCircuit;
    public string  $contestCircuitId;
    public string  $contestContactInfo;
    public string  $contestAwardCeremonyInfo;
    public string  $contestFeeInfo;
 
    public function mount(Contest $contest)
    {
        $this->contest = $contest;

        $this->organization = $contest->organization;

        $this->creator = Auth::user()->contact;

        $this->contestNameEn = $contest->name_en ?? '';
        $this->contestCountryId = $contest->country_id ?? $this->creator->country_id;
        $this->contestTimezoneId = $contest->timezone_id ?? $this->creator->timezone_id;
        $this->contestLangLocal = $contest->lang_local ?? $this->creator->lang_local;
        $this->contestNameLocal = $contest->name_local ?? '';
        $this->contestIsCircuit = $contest->is_circuit ?? false;
        $this->contestCircuitId = ($this->contestIsCircuit) ? ($contest->is_circuit ?? '') : '';
        $this->contestContactInfo = $this->contest->contact_info ?? '';
        $this->contestAwardCeremonyInfo = $this->contest->award_ceremony_info ?? '';
        $this->contestFeeInfo = $this->contest->fee_info ?? '';
    }

    public function rules()
    {
        return [
            // id
            'contestNameEn' => 'required|string|max:250',
            'contestCountryId' => 'required|string|exists:countries,id',
            'contestTimezoneId' => 'required|string|exists:timezones,id',
            'contestLangLocal' => 'string|max:6',
            'contestNameLocal' => 'string|max:250',
            'contestIsCircuit' => 'boolean',
            'contestCircuitId'    => [
                'required_if:contestIsCircuit,true',
                'nullable',
                'exists:contests,id'
            ],
            'contestContactInfo' => 'required|max:2000',
            'contestAwardCeremonyInfo' => 'required|max:2000',
            'contestFeeInfo' => 'required|max:2000',
        ];
    }

    public function modifyContest()
    {
        $validated = $this->validate();

        $this->contest->name_en = $validated['contestNameEn'];
        $this->contest->country_id = $validated['contestCountryId'];
        $this->contest->timezone_id = $validated['contestTimezoneId'];
        $this->contest->lang_local = $validated['contestLangLocal'];
        $this->contest->name_local = $validated['contestNameLocal'];
        $this->contest->is_circuit = $validated['contestIsCircuit'];
        $this->contest->circuit_id = $validated['contestCircuitId'] ?: null;
        $this->contest->contact_info = $validated['contestContactInfo'];
        $this->contest->award_ceremony_info = $validated['contestAwardCeremonyInfo'];
        $this->contest->fee_info = $validated['contestFeeInfo'];

        $this->contest->save();

        // redirect itself
        return redirect()
            ->route('organization.design.contest.modify-name', ['contest' => $this->contest])
            ->with('success', __('Contest infos updated.'));

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

                <form wire:submit="modifyContest">
                    @csrf
                    
                    <!-- contestNameEn -->
                    <div class="mb-4">
                        <x-input-label for="contestNameEn" :value="__('Contest denomination, english')" />
                        <x-text-input wire:model="contestNameEn" id="contestNameEn" name="contestNameEn" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="contestNameEn" class="mt-2" />
                    </div>

                    <!-- contestCountryId -->
                    <x-select-country-app wire:model="contestCountryId" :country_id="$contestCountryId" required /> 

                    <!-- contestTimezoneId -->
                    <x-select-timezone-app wire:model="contestTimezoneId" :country_id="$contestTimezoneId" required /> 

                    <!-- contestLangLocal -->
                    <div class="mb-4">
                        <x-input-label for="contestLangLocal" :value="__('Local language internet code')" />
                        <x-text-input wire:model="contestLangLocal" id="contestLangLocal" name="contestLangLocal" 
                            class="block mt-1 w-48" type="text" />
                        <p class="small">{{ __('Internet language code for web use, i.e. it_IT') }}</p>
                        <x-input-error for="contestLangLocal" class="mt-2" />
                    </div>

                    <!-- contestNameLocal -->
                    <div class="mb-4">
                        <x-input-label for="contestNameLocal" :value="__('Contest denomination, for local language')" />
                        <x-text-input wire:model="contestNameLocal" id="contestNameLocal" name="contestNameLocal" 
                            lang="{{ $contestLangLocal }}" class="block mt-1 w-full" type="text" />
                        <x-input-error for="contestNameLocal" class="mt-2" />
                    </div>

                    <!-- Is a Circuit  -->
                    <div class="mb-4">
                        <x-input-label for="contestIsCircuit" :value="__('Circuit record')" />
                            <x-checkbox wire:model="contestIsCircuit" id="contestIsCircuit" name="contestIsCircuit" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                            {{ __('Is a Circuit') }}
                        </label>
                        <p class="small">{{ __('Circuit is a contests aggregation') }}</p>
                        <x-input-error for="contestIsCircuit" class="mt-2" />
                    </div>
                    <!--/Is a Circuit -->

                    <!-- contestCircuitId -->
                    <div class="mb-4">
                        <x-input-label for="contestCircuitId" :value="__('Circuit ID')" />
                        <x-text-input wire:model="contestCircuitId" id="contestCircuitId" name="contestCircuitId" 
                            lang="{{ $contestCircuitId }}" class="block mt-1 w-full" type="text" />
                        <p class="small">{{ __('TODO: change in a select form field') }}</p>
                        <x-input-error for="contestCircuitId" class="mt-2" />
                    </div>

                    <!-- contestContactInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="contestContactInfo" :value="__('Contest Contact info, HQ postal address, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="contestContactInfo"
                        wire:model="contestContactInfo"
                        >{{ old('contestContactInfo') }}</textarea>
                        <x-input-error for="contestContactInfo" class="mt-2" />
                    </div>
                    
                    <!-- contestAwardCeremonyInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="contestAwardCeremonyInfo" :value="__('Award ceremony info, online and-or in person, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="contestAwardCeremonyInfo"
                        wire:model="contestAwardCeremonyInfo"
                        >{{ old('contestAwardCeremonyInfo') }}</textarea>
                        <x-input-error for="contestAwardCeremonyInfo" class="mt-2" />
                    </div>
                    
                    <!-- contestFeeInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="contestFeeInfo" :value="__('Fee payment infos, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="contestFeeInfo"
                        wire:model="contestFeeInfo"
                        >{{ old('contestFeeInfo') }}</textarea>
                        <x-input-error for="contestFeeInfo" class="mt-2" />
                    </div>
                    
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
