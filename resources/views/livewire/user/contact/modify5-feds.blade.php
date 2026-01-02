<div>
    <!-- header -->
    <h2 class="fyk text-2xl mb-4">{{ __('Update your personal info') }}</h2>
    <p class="mb-4">
        <a  href="{{ route('dashboard') }}"
            rel="noopener noreferrer">
        [ {{ __('Back to dashboard') }} ]
        </a>
    </p>
    <hr class="my-4" />
    <br />
    <br />

    <!-- success -->
    @if (session('success'))
    <div class="fyk text-2xl float-end font-medium rounded-md px-4 py-2">
        {{ session('success') }}
    </div>
    @endif

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- nav bar here -->
    <h3 class="fyk text-xl mb-4"><em>{{ __("Additional infos...")}}</em> required by </h3>    

    <h3 class="fyk text-2xl mb-4">{{$federation->country->flag_code}} {{$federation->id}} | {{$federation->name_en}}</h3>
    <p class="small">{{ __("When field is empty show a default value")}}</p>
    <p class="small">{{ __("When you insert in field a default value de facto you require it's removing")}}</p>
    <br style="clear:both;" />
    <br />
    <form wire:submit.prevent="updateUserContactMore">

        {{-- Cicla sulle definizioni dei campi caricate nel mount() --}}
        @foreach ($fieldDefinitions as $field)
            <div class="mb-4" wire:key="field-{{$field->id}}">
                <label for="{{ $field->field_name }}" class="fyk block font-medium text-2xl text-gray-700" >
                    {{ $field->field_label }}
                </label>
                <input
                    type="text"
                    id="{{ $field->field_name }}"
                    wire:model.live="formData.{{ $field->field_name }}"
                    placeholder="{{ $field->field_default_value }}"
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
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
</div>
