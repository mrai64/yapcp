<div>
    <p class="mb-4">{{ __('Modify Federation data here.')}}</p>
    <p class="mb-4">
        <a href="{{ route('federation-list') }}" 
            target="_blank" rel="noopener noreferrer">
            {{ __('Back to Federation list') }} 
        </a>
    </p>
    <form wire:submit="update">
        @csrf 
        
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('Federation Name') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="name"
                wire:model.live.debounce.500ms="name" 
                required="required" 
            />
            @error('name')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>
        
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="code">
                {{ __('Federation Shortcode')}}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                wire:model.live.debounce.500ms="code" 
                type="text" name="code"
                required="required" 
            />
            <div class="alert alert-danger small">@error('code') {{ $message }} @enderror</div>
        </div>
        
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{__('Official website')}}
            </label>
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            wire:model.live="website" 
            type="text" name="website" 
            value="{{ old('website') }}"
            >
            <div class="alert alert-danger small">@error('website') {{ __($message) }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="country_id">
                {{ __('Country') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live="country_id"
                name="country_id" 
                required="required"
                >

                @foreach ($countries as $country)
                <option value="{{ trim($country->id) }}" {{ ($country->id === $country_id ) ? 'selected' : '' }}>{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('country_id') {{ $message }} @enderror</div>
        </div>
        
        <div class="mb-4">
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="contact">
                {{ __('Federation Contacts') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="contact"
                wire:model="contact"
            >{{ old('contact') }}</textarea>
            <div class="small">@error('contact') {{ $message }} @enderror</div>
        </div>

        <p>&nbsp;</p>
        <a href="/federation/section/list/{{$id}}" 
            class="fyk text-xl mb-4"
            target="_blank" rel="noopener noreferrer"
            >
        Federation' Coded Sections List 🗒️
        </a>

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>

    </form>
</div>
