<div>
    <p class="fyk text-2xl">
         try https://yapcp.test/user/contact/modify5/FIAF/019b519e-129d-73d4-ba13-ba922a8aeb85
    </p>
    <form wire:submit.prevent="updateUserContactMore">

        @if (session()->has('success'))
            <div class="p-3 mb-4 text-sm text-green-700 bg-green-100 rounded-lg" role="alert">
                {{ session('success') }}
            </div>
        @endif

        {{-- Cicla sulle definizioni dei campi caricate nel mount() --}}
        @foreach ($fieldDefinitions as $field)
            <div class="mb-4" wire:key="field-{{$field->id}}">
                <label for="{{ $field->field_name }}" class="block text-sm font-medium text-gray-700">
                    {{ $field->field_label }}
                </label>

                {{-- Utilizzo di wire:model.live per la validazione in tempo reale (o .blur o senza) --}}
                <input
                    type="text"
                    id="{{ $field->field_name }}"
                    wire:model.live="formData.{{ $field->field_name }}"
                    placeholder="{{ $field->field_default_value }}"
                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                >
                <p class="small">{{$field->field_suggest}}</p>
                {{-- Visualizzazione dell'errore specifico del campo --}}
                @error('formData.' . $field->field_name)
                    <p class="mt-2 mb-4 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update, then next panel') }}
        </button>
    </form>

    {{-- Utile per il debug: mostra i dati in tempo reale --}}
    {{-- <pre>{{ print_r($formData, true) }}</pre> --}}
</div>
