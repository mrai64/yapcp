<?php

/**
 * Organization ContestDesign / Circuit Stemp 1 - Name and Circuit Infos
 *   Circuit is a group of contests, so here we need infos that are common
 *   to all contests, i.e. of circuit.
 */

use App\Models\Contest;
use App\Models\Organization;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class () extends Component {
    //
    public Contest      $circuit;
    public Organization $organization;
    public UserContact  $creator;
    // form fields
    public string    $circuitNameEn;
    public string    $circuitCountryId;
    public string    $circuitTimezoneId;
    public string    $circuitLangLocal;
    public string    $circuitNameLocal;
    public string    $circuitContactInfo;
    public string    $circuitAwardCeremonyInfo;
    public string    $circuitFeeInfo;
    // other model fields in other forms
    public function mount(Contest $contest)
    {
        $this->circuit      = $contest;
        $this->organization = $contest->organization;
        $this->creator      = Auth::user()->contact;
        //
        $this->circuitNameEn            = $contest->name_en     ?? '';
        $this->circuitCountryId         = $contest->country_id  ?? $this->creator->country_id;
        $this->circuitTimezoneId        = $contest->timezone_id ?? $this->creator->timezone_id;
        $this->circuitLangLocal         = $contest->lang_local  ?? $this->creator->lang_local;
        $this->circuitNameLocal         = $contest->name_local  ?? '';
        $this->circuitContactInfo       = $this->circuit->contact_info ?? '';
        $this->circuitAwardCeremonyInfo = $this->circuit->award_ceremony_info ?? '';
        $this->circuitFeeInfo           = $this->circuit->fee_info ?? '';
    }
    public function rules()
    {
        return [
            // id
            'circuitNameEn' => 'required|string|max:250',
            'circuitCountryId' => 'required|string|exists:countries,id',
            'circuitTimezoneId' => 'required|string|exists:timezones,id',
            'circuitLangLocal' => 'string|max:6',
            'circuitNameLocal' => 'string|max:250',
            'circuitContactInfo' => 'required|max:2000',
            'circuitAwardCeremonyInfo' => 'required|max:2000',
            'circuitFeeInfo' => 'required|max:2000',
        ];
    }

    public function modifyCircuit()
    {
        $validated = $this->validate();

        $this->circuit->name_en = $validated['circuitNameEn'];
        $this->circuit->country_id = $validated['circuitCountryId'];
        $this->circuit->timezone_id = $validated['circuitTimezoneId'];
        $this->circuit->lang_local = $validated['circuitLangLocal'];
        $this->circuit->name_local = $validated['circuitNameLocal'];
        $this->circuit->contact_info = $validated['circuitContactInfo'];
        $this->circuit->award_ceremony_info = $validated['circuitAwardCeremonyInfo'];
        $this->circuit->fee_info = $validated['circuitFeeInfo'];

        $this->circuit->save();

        // redirect itself
        return redirect()
            ->route('organization.design.circuit.modify-name', ['contest' => $this->circuit])
            ->with('success', __('Contest infos updated.'));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Modify Circuit infos') }}
        </h2>
        <hr class="mb-4" />
        <x-yapcp.organization.design.circuit-nav :circuit="$circuit" active="general" />
        <hr class="mb-2" />
        <!-- livewire:organization.design.circuit.general-nav :circuit="$circuit" / -->
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
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

                <div class="mb-4">
                    <p class="fyk text-xl">
                        {{__("Circuit is already created and this is the modify page") }}
                    </p>
                </div>

                <form wire:submit="modifyCircuit">
                    @csrf

                    <!-- circuitNameEn -->
                    <div class="mb-4">
                        <x-input-label for="circuitNameEn" :value="__('Circuit denomination, english')" />
                        <x-text-input wire:model="circuitNameEn" id="circuitNameEn" name="circuitNameEn" 
                            class="block mt-1 w-full" type="text" required />
                        <x-input-error for="circuitNameEn" class="mt-2" />
                    </div>

                    <!-- circuitCountryId -->
                    <x-select-country-app wire:model="circuitCountryId" :country_id="$circuitCountryId" required /> 

                    <!-- circuitTimezoneId -->
                    <x-select-timezone-app wire:model="circuitTimezoneId" :timezone_id="$circuitTimezoneId" required /> 

                    <!-- circuitLangLocal -->
                    <div class="mb-4">
                        <x-input-label for="circuitLangLocal" :value="__('Local language internet code')" />
                        <x-text-input wire:model="circuitLangLocal" id="circuitLangLocal" name="circuitLangLocal" 
                            class="block mt-1 w-48" type="text" />
                        <p class="small">{{ __('Internet language code for web use, i.e. it_IT') }}</p>
                        <x-input-error for="circuitLangLocal" class="mt-2" />
                    </div>

                    <!-- circuitNameLocal -->
                    <div class="mb-4">
                        <x-input-label for="circuitNameLocal" :value="__('Circuit denomination, for local language')" />
                        <x-text-input wire:model="circuitNameLocal" id="circuitNameLocal" name="circuitNameLocal" 
                            lang="{{ $circuitLangLocal }}" class="block mt-1 w-full" type="text" />
                        <x-input-error for="circuitNameLocal" class="mt-2" />
                    </div>

                    <!-- circuitContactInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="circuitContactInfo" :value="__('Circuit Contact info, HQ postal address, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="circuitContactInfo"
                        wire:model="circuitContactInfo"
                        >{{ old('circuitContactInfo') }}</textarea>
                        <x-input-error for="circuitContactInfo" class="mt-2" />
                    </div>

                    <!-- circuitAwardCeremonyInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="circuitAwardCeremonyInfo" :value="__('Award ceremony info, online and-or in person, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="circuitAwardCeremonyInfo"
                        wire:model="circuitAwardCeremonyInfo"
                        >{{ old('circuitAwardCeremonyInfo') }}</textarea>
                        <x-input-error for="circuitAwardCeremonyInfo" class="mt-2" />
                        <p class="small">
                            {{  __("This is the text that in result notification follow the words:") }}
                            &laquo; {{ __("We invite you to partecipate at our award ceremony")}} &raquo;
                        </p>
                    </div>

                    <!-- circuitFeeInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="circuitFeeInfo" :value="__('Fee payment infos, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="circuitFeeInfo"
                        wire:model="circuitFeeInfo"
                        >{{ old('circuitFeeInfo') }}</textarea>
                        <x-input-error for="circuitFeeInfo" class="mt-2" />
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
