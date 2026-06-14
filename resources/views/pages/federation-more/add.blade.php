<?php

/**
 * Add or update a federation-more record for a federation
 */

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationMoresReferencedTable;
use Illuminate\Support\Facades\Log;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;
use function Livewire\Volt\rules;

// state - 
state([
    'federation',
    'referencedTableSet' => [],
    'federationId' => null,
    'referencedTable' => '',
    'fieldName' => '',
    'fieldLabel' => '',
    'fieldValidation' => '',
    'fieldDefault' => '',
    'fieldSuggest' => '',
]);

// first
mount(function (Federation $federation) {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $this->federation = $federation;
    $this->referencedTableSet = FederationMoresReferencedTable::all()->toArray();
    $this->federationId = $federation->id;
});

// to validate
rules(function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    return [
        'referencedTable' => 'required|string',
        'fieldName' => 'required|string|min:3|max:255',
        'fieldLabel' => 'required|string|min:3|max:255',
        'fieldValidation' => 'required|string|min:3|max:255',
        'fieldSuggest' => 'required|string|min:3|max:255',
        'fieldDefault' => 'required|string|max:255',
    ];
});

$addFederationMore = function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $validate = $this->validate();
    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' validated:' . json_encode($validate));
    
    $federationMore = FederationMore::updateOrCreate(
        [
            'federation_id' => $this->federationId,
            'referenced_table' => $validate['referencedTable'],
            'field_name' => $validate['fieldName'],
        ],
        [
            'field_label' => $validate['fieldLabel'],
            'field_validation_rules' => $validate['fieldValidation'],
            'field_default_value' => $validate['fieldDefault'],
            'field_suggest' => $validate['fieldSuggest'],
        ]
    );

    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationMore:' . json_encode($federationMore) );
    // redirect
    // redirect
    return redirect()
        ->route('federation-more.list', ['federation' => $this->federation])
        ->with('success', __('New federation-more field added, well done!'));
};

?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __("Federation 'more field' for :name", ['name' => $federation->name_en]) }}
        </h2>
        <hr />
        <br />
        <p class="small">
            {{ __("The federation more field are required fields that interest only a federation adn not is a common field.")}}
            {{ __("I.e. the federation card id si a federation-more field, when surname not, it's a common field.")}}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('federation.modify', ['federation' => $federation]) }}">
                [ {{ __('Back to Federation') }} ]
            </a>
        </p>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <form wire:submit="addFederationMore">
                @csrf
                <!-- referenced table -->
                <div class="mb-4">
                    <x-input-label for="referencedTable" :value="__('Referenced table')" />
                    <select 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        wire:model.live="referencedTable"
                        name="referencedTable" 
                        required="required">
                        <option value="">{{ __('Select a table...') }}</option>
                        @foreach ($referencedTableSet as $referencedTableItem)
                            <option value="{{ trim($referencedTableItem['referenced_table']) }}">
                                {{ $referencedTableItem['referenced_table'] }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error for="referencedTable" class="mt-2" />
                </div>

                <!-- field name -->
                <div class="mb-4">
                    <x-input-label for="fieldName" :value="__('Field label')" />
                    <x-text-input wire:model="fieldName" id="fieldName" class="block mt-1 w-full" type="text" name="fieldName" required placeholder="{{ __('clear label for field name, english') }}"/>
                    <x-input-error for="fieldName" class="mt-2" />
                </div>
                <!--/field name -->

                <!-- field label -->
                <div class="mb-4">
                    <x-input-label for="fieldLabel" :value="__('Field name')" />
                    <x-text-input wire:model="fieldLabel" id="fieldLabel" class="block mt-1 w-full" type="text" name="fieldLabel" required placeholder="{{ __('camelCase, english') }}"/>
                    <x-input-error for="fieldLabel" class="mt-2" />
                </div>
                <!--/field label -->

                <!-- field validation rules -->
                <div class="mb-4">
                    <x-input-label for="fieldValidation" :value="__('Field validation rules')" />
                    <x-text-input wire:model="fieldValidation" id="fieldValidation" class="block mt-1 w-full" type="text" name="fieldValidation" required placeholder="{{ __('rules to validate field, in laravel way') }}"/>
                    <x-input-error for="fieldValidation" class="mt-2" />
                </div>
                <!--/field validation rules -->

                <!-- field default value -->
                <div class="mb-4">
                    <x-input-label for="fieldDefault" :value="__('Field default value')" />
                    <x-text-input wire:model="fieldDefault" id="fieldDefault" class="block mt-1 w-full" type="text" name="fieldDefault" required placeholder="{{ __('value used when user´ field is missing') }}"/>
                    <x-input-error for="fieldDefault" class="mt-2" />
                </div>
                <!--/field default value -->

                <!-- field suggest -->
                <div class="mb-4">
                    <x-input-label for="fieldSuggest" :value="__('Field suggest')" />
                    <x-text-input wire:model="fieldSuggest" id="fieldSuggest" class="block mt-1 w-full" type="text" name="fieldSuggest" required placeholder="{{ __('a short suggestion for the field') }}"/>
                    <x-input-error for="fieldSuggest" class="mt-2" />
                </div>
                <!--/field suggest -->

                <x-button class="mt-2 ms-4">
                    {{ __('Add new') }}
                </x-button>

            </form>
            <x-footer-app />
        </div>
    </div>
</div>