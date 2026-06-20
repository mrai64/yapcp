<?php

/**
 * Federation remove by admin
 * 
 */

use App\Models\Federation;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Log;

new class extends Component {
    
    public Federation $federation;
    public string $federationId;
    public string $federationCountryId;
    public string $federationNameEn;
    public string $federationWebsite;
    public string $federationContactInfo;
    public string $federationLocalLang;
    public string $federationNameLocal;
    public string $federationTimezoneId;

    public function mount(Federation $federation)
    {
        $this->$federation = $federation;

        $this->federationId = $federation->id;
        $this->federationCountryId = $federation->country_id;
        $this->federationNameEn = $federation->name_en;
        $this->federationWebsite = $federation->website;
        $this->federationContactInfo = $federation->contact_info;
        $this->federationLocalLang = $federation->local_lang;
        $this->federationNameLocal = $federation->name_local;
        $this->federationTimezoneId = $federation->timezone_id;
    }

    public function removeFederation()
    {
        $this->federation->delete();

        return redirect()
            ->route('federation.listed')
            ->with('success', __('Federation successfully removed.'));
    }
}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Remove Federation') }}
        </h2>
        <hr class="mb-4" />
        <p class="small text-red-600">‼️ {{ __('LAST LAST CALL. Are you SURE to delete that?') }}</p>
        <hr class="mb-4" />
        <x-header-link-app 
            txt="Back to User dashboard" 
            url="{{ route('user.dashboard') }}" />
		<x-header-link-app 
			txt="Federation list" 
			url="{{ route('federation.listed') }}" />
		<x-header-link-app 
			txt="Federation Update" 
			url="{{ route('federation.modify', ['federation' => $federation]) }}" />
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

                <form wire:submit="removeFederation">
                    @csrf
                    
                    <!-- federationId -->
                    <div class="mb-4">
                        <x-input-label for="federationId" :value="__('Federation ID')" />
                        <x-text-input wire:model="federationId" id="federationId" name="federationId" class="block mt-1 w-full" type="text" disabled />
                    </div>

                    <!-- country -->
                    <div class="mb-4">
                        <x-input-label for="federationCountryId" :value="__('Country ID')" />
                        <x-text-input wire:model="federationCountryId" id="federationCountryId" name="federationCountryId" class="block mt-1 w-full" type="text" disabled />
                    </div>

                    <!-- federationNameEn -->
                    <div class="mb-4">
                        <x-input-label for="federationNameEn" :value="__('Federation Name, english')" />
                        <x-text-input wire:model="federationNameEn" id="federationNameEn" name="federationNameEn" class="block mt-1 w-full" type="text" disabled />
                    </div>

                    <!-- federationWebsite -->
                    <div class="mb-4">
                        <x-input-label for="federationWebsite" :value="__('Official website')" />
                        <x-text-input wire:model="federationWebsite" id="federationWebsite" name="federationWebsite" class="block mt-1 w-full" type="url" disabled />
                    </div>

                    <!-- federationLocalLang -->
                    <div class="mb-4">
                        <x-input-label for="federationLocalLang" :value="__('Local lang code')" />
                        <x-text-input wire:model="federationLocalLang" id="federationLocalLang" name="federationNameEn" class="block mt-1 w-full" type="text" disabled />
                    </div>

                    <!-- timezone select -->
                    <div class="mb-4">
                        <x-input-label for="federationTimezoneId" :value="__('Local lang code')" />
                        <x-text-input wire:model="federationTimezoneId" id="federationTimezoneId" name="federationTimezoneId" class="block mt-1 w-full" type="text" disabled />
                    </div>

                    <!-- federationContactInfo -->
                    <div class="mb-4">
                        <style>textarea {resize:vertical;}</style>
                        <x-input-label for="federationContactInfo" :value="__('Contact info, HQ postal address, english')" />
                        <textarea 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="federationContactInfo"
                        wire:model="federationContactInfo"
                        disabled
                        >{{ old('federationContactInfo') }}</textarea>
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('LAST CALL. Are you SURE to delete that?') }}
                    </x-button>
                </form>

            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
