<?php

/**
 * remove a federation-more record for a federation
 * only readonly fields
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
    'isInUse' => false,
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
    $this->authorize('delete', $federation_more);

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
    
    // Controllo integrità: il record non può essere eliminato se è già in uso
    $this->isInUse = $federation_more->isInUse();
});

$removeFederationMore = function (){
    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

    if ($this->federationMore->isInUse()) {
        session()->flash('error', __('Cannot delete: this field is already associated with existing data.'));
        return;
    }

    // Usiamo l'istanza già caricata per fare il delete
    $this->federationMore->delete([
        'id' => $this->federationMore->id,
    ]);

    Log::info('Component ' . __FILE__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ 
        . ' federationMore:' . json_encode($this->federationMore) );
    // redirect
    return redirect()
        ->route('federation-more.list', ['federation' => $this->federation])
        ->with('success', __('Federation-more field record removed, well done!'));
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

            <form wire:submit="removeFederationMore">
                @csrf

                @if($isInUse)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                    <p class="font-bold">{{ __('Action Prohibited') }}</p>
                    <p>{{ __('This configuration is currently in use by users or works. Deletion is disabled to protect data integrity.') }}</p>
                </div>
                @else
                <button type="submit"
                    class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3 {{ $isInUse ? 'opacity-50 cursor-not-allowed' : '' }}"
                    >
                    {{ __('Check, then delete') }}
                </button>
                @endif
                <br><br>

                <!-- referenced table -->
                <div class="mb-4">
                    <label for="referencedTable"
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" >
                        {{ __("Referenced table") }}
                        | {{__('required')}}
                    </label>
                    <input 
                        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                        type="text" name="referencedTable" 
                        wire:model="referencedTable"
                        readonly="readonly"
                        />
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
                        readonly="readonly"
                        />
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
                        readonly="readonly"
                        />
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
                        readonly="readonly"
                        />
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
                        readonly="readonly"
                        />
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
                        readonly="readonly"
                        />
                </div><!-- field suggest -->

                <hr />

            </form>
            <x-footer-app />
        </div>
    </div>
</div>