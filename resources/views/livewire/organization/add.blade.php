<?php 

/**
 * User add Organization
 * 
 * @see /app/Livewire/Organization/App.php 
 */

?>

<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('New Organization') }}
        </h2>
        <hr />
        <br />
        <p class="small">
            {{ __("To avoid trouble please check if your Organization is already in platform.")}}
        </p>
        <p class="fyk text-xl font-medium mb-4">
            <a href="{{ route('organization.list') }}">
                [ {{__('Organization list')}} ]
            </a>
        </p>
    </header>
    <form wire:submit="save">
        @csrf

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
            <label for="email" 
                class="block mt-4 font-medium text-sm text-gray-700"
                >
                {{__('Secretary email')}}
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
                {{__('Official website')}}
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

        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="federationContact">
                {{ __('Organization HQ and reference contact') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="federationContact"
                wire:model="federationContact"
            >{{ old('federationContact') }}</textarea>
            <div class="small">@error('federationContact') {{ $message }} @enderror</div>
        </div><!-- contact info -->


        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Add new Organization') }}
        </button>
        <p class="small">
            {{__("After insert you land in Organization List")}}
        </p>

    </form>
</div>
