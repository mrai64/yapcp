<?php

/**
 * FederationMore - Modify a present Federation "more fields"
 *   required over user_contact_mores, user_work_mores, and
 *   other <table>_mores in future
 *
 */

use App\Models\Federation;
use App\Models\FederationMore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component {
    //
    public Federation     $federation;
    public FederationMore $federationMore;
    public bool           $isAdmin;
    //
    public string         $fedMoreReferencedId;
    public string         $fedMoreFederationId;
    public string         $fedMoreFieldName;
    public string         $fedMoreFieldLabel;
    public string         $fedMoreValidationRules;
    public string         $fedMoreDefaultValue;
    public string         $fedMoreSuggest;
    // from routes/web
    public function mount(FederationMore $federation_more)
    {
        $this->federationMore = $federation_more;
        $this->federation     = $federation_more->federation;
        $this->isAdmin = Auth::user()->isAdmin() ?? false;
        //
        $this->fedMoreReferencedId = $this->federationMore->referenced;
        $this->fedMoreFederationId = $this->federationMore->federation_id;
        $this->fedMoreFieldName    = $this->federationMore->field_name;
        $this->fedMoreFieldLabel   = $this->federationMore->field_label;
        $this->fedMoreValidationRules = $this->federationMore->field_validation_rules;
        $this->fedMoreDefaultValue = $this->federationMore->field_default_value;
        $this->fedMoreSuggest      = $this->federationMore->field_suggest;
    }
    //
    public function rules(): array
    {
        return [
            'fedMoreReferencedId' => 'required|string|exists:federation_mores_referenced_sets,id',
            'fedMoreFieldName' => 'required|string|max:20|unique:federation_mores,field_name',
            'fedMoreFieldLabel' => 'required|string|max:255',
            'fedMoreValidationRules' => 'required|string|max:255',
            'fedMoreDefaultValue' => 'required|string|max:255',
            'fedMoreSuggest' => 'required|string|max:255',
        ];
    }
    //
}; ?>

<div>
    <x-slot name="header">
		<h2 class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
			{{ $federation->name_en }}
			<br />
            <span class="text-red-600">
                {{ __('Federation More fields Risky Modify') }}
            </span>
		</h2>
		<hr class="mb-4 mt-4" />
		<x-yapcp.header-link 
			txt="User dashboard" 
			url="{{ route('user.dashboard') }}" />
		<x-yapcp.header-link 
			txt="Federation list" 
			url="{{ route('federation.listed') }}" />
		<x-yapcp.header-link 
			txt="Federation More list" 
			url="{{ route('federation-more.listed', ['federation' => $federation]) }}" />
		@if ($isAdmin)
		<x-yapcp.header-link 
			txt="Add a More field" 
			url="{{ route('federation-more.add', ['federation' => $federation]) }}" />
		@endif
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

                <div class="fyk text-2xl text-red-600">
                    {{ __("Do not use this module unless you know exactly what you're doing; any mistake here will cause part of the platform to crash. Think of it as performing surgery on a bare nerve.") }}
                </div>

                <div class="fyk font-semibold text-2xl text-gray-800 leading-tight fyk">
                    {{ __("Field Name") }}:
                    <br />
                    {{ $fedMoreFieldName }}
                </div>
                <p class="small">{{ __("Instead of change field name you can add a new field name and unuse, or delete that.")}}</p>

                <form wire:submit="modifyFederationMore">
                    @csrf

                    <!-- referenced table select -->
                    <x-select-referenced-app wire:model="fedMoreReferencedId" :referenced_id="$fedMoreReferencedId" /> 

                    <!-- form field label -->
                    <div class="mb-4">
                        <x-input-label for="fedMoreFieldLabel" :value="__('Form Field Label')" />
                        <x-text-input wire:model="fedMoreFieldLabel" id="fedMoreFieldLabel" name="fedMoreFieldLabel" class="block mt-1 w-full" type="text" required placeholder="{{ __('Label for form') }}" />
                        <p class="small">
                            {{ __("That's the form label in english. Clear and concise.") }}
                        </p>
                        <x-input-error for="fedMoreFieldLabel" class="mt-2" />
                    </div>

                    <!-- form field validation rule -->
                    <div class="mb-4">
                        <x-input-label for="fedMoreValidationRules" :value="__('Field validation rules')" />
                        <x-text-input wire:model="fedMoreValidationRules" id="fedMoreValidationRules" name="fedMoreValidationRules" class="block mt-1 w-full" type="text" required placeholder="{{ __('Laravel validation rules') }}" />
                        <p class="small">
                            {{ __("That's the most dangerous point. Laravel validation rules.") }}
                        </p>
                        <x-input-error for="fedMoreValidationRules" class="mt-2" />
                    </div>

                    <!-- form field default value -->
                    <div class="mb-4">
                        <x-input-label for="fedMoreDefaultValue" :value="__('Field default value')" />
                        <x-text-input wire:model="fedMoreDefaultValue" id="fedMoreDefaultValue" name="fedMoreDefaultValue" class="block mt-1 w-full" type="text" placeholder="{{ __('Default value (facultative)') }}" />
                        <p class="small">
                            {{ __("That's the value used when no values are recorded. String upto 255 chars.") }}
                            {{ __("When default value is 'empty string', leave the field empty.") }}
                        </p>
                        <x-input-error for="fedMoreDefaultValue" class="mt-2" />
                    </div>

                    <!-- form field suggestion -->
                    <div class="mb-4">
                        <x-input-label for="fedMoreSuggest" :value="__('Form Field Suggest')" />
                        <x-text-input wire:model="fedMoreSuggest" id="fedMoreSuggest" name="fedMoreSuggest" class="block mt-1 w-full" type="text" required placeholder="{{ __('Suggest for field compilation') }}" />
                        <p class="small">
                            {{ __("That's the field suggest in english. Clear and concise.") }}
                        </p>
                        <x-input-error for="fedMoreSuggest" class="mt-2" />
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
