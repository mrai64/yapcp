<?php

/**
 * Modify and update a federation-more record for a federation
 *
 */

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\FederationMoresReferencedTable;
use Illuminate\Support\Facades\Log;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;
use function Livewire\Volt\rules;

// state - what are used in blade and fn
state([
    'federationMore',
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
mount(function (FederationMore $federation_more) {
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    
    // Autorizzazione esplicita: se fallisce, lancia 403 e vedrai i log ds() nella Policy
    $this->authorize('update', $federation_more);
    // Se usi il middleware 'can' nella rotta, questo è tecnicamente ridondante 
    // ma tenerlo qui garantisce sicurezza anche se cambi le rotte.
    // $this->authorize('update', $federation_more);

    $this->federationMore = $federation_more;
    $this->federation = $federation_more->federation;
    $this->referencedTableSet = FederationMoresReferencedTable::all()->toArray();
    $this->federationId = $this->federation->id;

    $this->referencedTable = $federation_more->referenced_table;
    $this->fieldName = $federation_more->field_name;
    $this->fieldLabel = $federation_more->field_label;
    $this->fieldValidation = $federation_more->field_validation_rules;
    $this->fieldDefault = $federation_more->field_default_value;
    $this->fieldSuggest = $federation_more->field_suggest;
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

$modifyFederationMore = function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
    $validate = $this->validate();
    Log::debug('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' validated:' . json_encode($validate));

    // Usiamo l'istanza già caricata per fare l'update
    $this->federationMore->update([
        'federation_id' => $this->federationId,
        'referenced_table' => $validate['referencedTable'],
        'field_name' => $validate['fieldName'],
        'field_label' => $validate['fieldLabel'],
        'field_validation_rules' => $validate['fieldValidation'],
        'field_default_value' => $validate['fieldDefault'],
        'field_suggest' => $validate['fieldSuggest'],
    ]);

    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationMore:' . json_encode($this->federationMore) );
    // redirect
    return redirect()
        ->route('federation-more.list', ['federation' => $this->federation])
        ->with('success', __('Federation-more field record modified, well done!'));
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

            <form wire:submit="modifyFederationMore">
                @csrf
                <!-- referenced table -->
                <div class="mb-4">
                    <label for="referencedTable"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" >
                        {{ __("Referenced table") }}
                        | {{__('required')}}
                    </label>
                    <select 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        wire:model.live="referencedTable"
                        name="referencedTable" 
                        required="required"
                    >
                        <option value="">{{ __('Select a table...') }}</option>
                        @foreach ($referencedTableSet as $referencedTableItem)
                            <option value="{{ trim($referencedTableItem['referenced_table']) }}">
                                {{ $referencedTableItem['referenced_table'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('referencedTable')
                    <div class="small"> {{ $message }} </div>
                    @enderror
                </div>

                <!-- field name -->
                <div>
                    <label for="fieldName" 
                        class="block mt-4 font-medium text-sm text-gray-700"
                        >
                        {{__('Field name')}}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="fieldName" 
                        wire:model="fieldName"
                        required="required"
                        placeholder="{{ __('camelCase, english') }}"
                        />
                    @error('fieldName')
                    <div class="alert alert-danger small">{{ $message }}</div>
                    @enderror
                </div><!-- field name -->

                <!-- field label -->
                <div>
                    <label for="fieldLabel" 
                        class="block mt-4 font-medium text-sm text-gray-700"
                        >
                        {{__('Field label')}}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="fieldLabel" 
                        wire:model="fieldLabel"
                        required="required"
                        placeholder="{{ __('clear label for field name, english') }}"
                        />
                    @error('fieldLabel')
                    <div class="alert alert-danger small">{{ $message }}</div>
                    @enderror
                </div><!-- field label -->

                <!-- field validation rules -->
                <div>
                    <label for="fieldValidation" 
                        class="block mt-4 font-medium text-sm text-gray-700"
                        >
                        {{__('Field validation rules')}}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="fieldValidation" 
                        wire:model="fieldValidation"
                        required="required"
                        placeholder="{{ __('rules to validate field, in laravel way') }}"
                        />
                    @error('fieldValidation')
                    <div class="alert alert-danger small">{{ $message }}</div>
                    @enderror
                </div><!-- field validation rules -->

                <!-- field default value -->
                <div>
                    <label for="fieldDefault" 
                        class="block mt-4 font-medium text-sm text-gray-700"
                        >
                        {{__('Field default value')}}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="fieldDefault" 
                        wire:model="fieldDefault"
                        required="required"
                        placeholder="{{ __('that value is used when field is missing') }}"
                        />
                    @error('fieldDefault')
                    <div class="alert alert-danger small">{{ $message }}</div>
                    @enderror
                </div><!-- field default value -->

                <!-- field suggest -->
                <div>
                    <label for="fieldSuggest" 
                        class="block mt-4 font-medium text-sm text-gray-700"
                        >
                        {{__('Field suggest')}}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="fieldSuggest" 
                        wire:model="fieldSuggest"
                        required="required"
                        placeholder="{{ __('a short suggestion for the field') }}"
                        />
                    @error('fieldSuggest')
                    <div class="alert alert-danger small">{{ $message }}</div>
                    @enderror
                </div><!-- field suggest -->

                <hr />

                <button type="submit" 
                    class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
                    >
                    {{ __('Modify') }}
                </button>

            </form>

        </div>
    </div>
</div>