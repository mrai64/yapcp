<?php

/**
 * User Contact modify 5th of five
 * Lie: it's really "user contact more modify 1st of one"
 * 
 * For every federation that require one or more value for their
 * i.e. card id but also distinction codes
 *
 */
use Livewire\Volt\Component;
use App\Models\FederationMore;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Support\Collection;

new class extends Component {

    public UserContact $userContact;

    public array $formData = [];

    /** @var Collection */
    public $fieldDefinitions;

    public function mount(UserContact $user_contact): void
    {
        $this->userContact = $user_contact;

        // Carichiamo le definizioni dei campi ordinate per etichetta (field_label)
        // Puoi usare orderBy a livello di query (più efficiente) 
        // o ->all()->sortBy('field_label') sulla collection.
        $this->fieldDefinitions = FederationMore::where('referenced_table', 'user_contact_mores')
            ->orderBy('federation_id')
            ->orderBy('field_label')->get();

        // Recuperiamo i valori già salvati per questo utente
        $existingValues = UserContactMore::where('user_id', $user_contact->id)
            ->get()
            ->pluck('field_value', 'field_name')
            ->toArray();

        // Inizializziamo l'array del form con i valori esistenti o i default
        foreach ($this->fieldDefinitions as $definition) {
            $this->formData[$definition->field_name] = $existingValues[$definition->field_name] 
                ?? $definition->field_default_value 
                ?? '';
        }
    }

    public function rules(): array
    {
        $rules = [];
        foreach ($this->fieldDefinitions as $definition) {
            $validationRules = $definition->field_validation_rules;

            if (empty($validationRules)) {
                $rules['formData.' . $definition->field_name] = 'nullable|string|max:255';
                continue;
            }

            // Se la regola contiene 'regex:', può contenere alsuo interno il | che viene 
            // interpretato come separatore di campi, dobbiamo cnvertirlo come array per evitare 
            // che Laravel spezzi l'espressione regolare in corrispondenza del carattere '|'.
            if (str_contains($validationRules, 'regex:')) {
                $parts = explode('regex:', $validationRules, 2);
                $otherRules = array_filter(explode('|', rtrim($parts[0], '|')));
                $rules['formData.' . $definition->field_name] = array_merge($otherRules, ['regex:' . $parts[1]]);
            } else {
                $rules['formData.' . $definition->field_name] = $validationRules;
            }
        }
        return $rules;
    }

    protected function validationAttributes(): array
    {
        $attributes = [];
        foreach ($this->fieldDefinitions as $definition) {
            $attributes['formData.' . $definition->field_name] = $definition->field_label;
        }
        return $attributes;
    }

    public function updateUserContact5th()
    {
        $validated = $this->validate();
        ds($validated['formData']);

        foreach ($validated['formData'] as $fieldName => $value) {
            // Identifichiamo a quale federazione appartiene il campo per salvare correttamente
            $definition = $this->fieldDefinitions->firstWhere('field_name', $fieldName);
            
            if ($definition) {
                UserContactMore::updateOrCreate(
                    [
                        'user_id'       => $this->userContact->id,
                        'federation_id' => $definition->federation_id,
                        'field_name'    => $fieldName,
                    ],
                    ['field_value' => $value ?? '']
                );
            }
        }

        return redirect()
            ->route('user.contact.modify5', ['user_contact' => $this->userContact])
            ->with('success', __("Your federations related data was updated successfully"));
    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your personal info / 5th of five', ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="mb-4" />
        <livewire:user.contact.modify-nav :user_contact="$userContact" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />
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

                <form wire:submit="updateUserContact5th">
                    @csrf

                    @foreach ($fieldDefinitions->groupBy('federation_id') as $fedId => $fields)
                        <div class="mb-8 border-b border-gray-100 pb-6 last:border-0 last:pb-0">
                            <h3 class="fyk text-lg font-semibold text-gray-700 mb-4 uppercase tracking-wide border-l-4 border-indigo-500 pl-3">
                                {{ $fedId }}
                            </h3>
                            
                            @foreach ($fields as $field)
                                <div class="mb-4 ml-4">
                                    <x-input-label for="field-{{ $field->id }}" :value="$field->field_label" />
                                    <x-text-input 
                                        wire:model.blur="formData.{{ $field->field_name }}" 
                                        id="field-{{ $field->id }}" 
                                        class="block mt-1 w-full" 
                                        type="text" 
                                        :placeholder="$field->field_suggest" />
                                    <x-input-error for="formData.{{ $field->field_name }}" class="mt-2" />
                                </div>
                            @endforeach

                        </div>
                    @endforeach

                    <x-button class="mt-4">
                        {{ __('Update, finish profile') }}
                    </x-button>
                </form>
            </div>
        </div>
    </div>
    <x-footer-app />
</div>
