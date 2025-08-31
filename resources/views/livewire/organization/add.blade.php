<div>
    <p class="">Well, new organization? Insert Few data here.</p>
    <p class="mb-4">Before, check 
        <a href="{{ route('organization-list') }}">
        [ {{__('Organization list')}} ]
        </a>
    </p>
    <form wire:submit="save">
        @csrf

        <div>
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="country_id">
                {{ __('Country') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="country_id"
                name="country_id" 
                required="required
                >
                <option value="">{{ __('-- choose country --') }}</option>
                @foreach ($countries as $country)
                <option value="{{ $country->id }}">{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('country_id') {{ $message }} @enderror</div>
        </div>

        <div>
            <label for="name" 
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('name')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="name" 
                wire:model="name"
                value="{{ old('name') }}"
                required="required"
                />
            @error('name')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="email" 
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('email')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="email" name="email" 
                wire:model="email"
                value="{{ old('email') }}"
                required="required"
                />
            @error('email')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="website" 
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('website')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="url" name="website" 
                wire:model="website"
                value="{{ old('website') }}"
                required="required"
                placeholder="An https:// url"
                />
            @error('website')
            <div class="alert alert-danger small">{{ $message }}</div>
            @enderror
        </div>

        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add new organization') }}
        </button>

    </form>
</div>
