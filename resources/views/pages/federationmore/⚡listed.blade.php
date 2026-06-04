<?php

/**
 * List 'federation more' fields for federation
 *
 */
use App\Models\Federation;
use App\Models\FederationMore;
use function Livewire\Volt\state;
use function Livewire\Volt\mount;

state([
    'federation',
    'mores' => []
]);

mount(function (Federation $federation) {
    $this->federation = $federation;
    $this->mores = FederationMore::where('federation_id', $federation->id)->get();
});

?>

<div>
    <x-slot name="header">
        <h2 class="fyk font-semibold text-xl text-gray-800 leading-tight">
            {{ __("Federation 'more fields' for :name", ['name' => $federation->name_en]) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="fyk text-xl font-bold">{{ __("Custom Fields List") }}</h3>
                        <p class="text-sm text-gray-600 mt-1">
                            {{ __("These custom fields are specifically requested by :name for user contacts or works.", ['name' => $federation->name_en]) }}
                        </p>
                    </div>
                    <div class="flex gap-4">
                        <a href="{{ route('federation.modify', ['federation' => $federation]) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 transition duration-150">
                            &larr; {{ __('Federation') }}
                        </a>
                        <a href="{{ route('federation-more.add', ['federation' => $federation]) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 transition duration-150">
                            {{ __('Add new field') }}
                        </a>
                    </div>
                </div>

                @if($mores->isEmpty())
                    <div class="border text-xl rounded-md px-4 py-6 text-center text-gray-500">
                        {{ __('No custom fields defined for this federation yet.') }}
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b bg-gray-50">
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Referenced Table') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Field Name') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Label') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Validation Rules') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Default Value') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase">{{ __('Suggest/Help') }}</th>
                                    <th class="py-3 px-4 text-xs font-semibold text-gray-600 uppercase text-right">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach($mores as $more)
                                    <tr class="hover:bg-gray-50 transition duration-150">
                                        <td class="py-3 px-4 text-sm font-medium text-gray-900">
                                            <span class="px-2 py-1 text-xs font-semibold bg-indigo-50 text-indigo-700 rounded-full border border-indigo-100">
                                                {{ $more->referenced_table }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-sm font-mono font-bold text-gray-900">
                                            {{ $more->field_name }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-700">
                                            {{ $more->field_label }}
                                        </td>
                                        <td class="py-3 px-4 text-sm font-mono text-gray-600">
                                            {{ $more->field_validation_rules }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-600">
                                            {{ $more->field_default_value }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-gray-500 italic">
                                            {{ $more->field_suggest }}
                                        </td>
                                        <td class="py-3 px-4 text-sm text-right space-x-2">
                                            <a href="{{ route('federation-more.modify', ['federationMore' => $more->id]) }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                [ {{ __('Modify') }} ]
                                            </a>
                                            <a href="{{ route('federation-more.delete', ['federationMore' => $more->id]) }}" class="text-red-600 hover:text-red-900 font-semibold">
                                                [ {{ __('Remove') }} ]
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>