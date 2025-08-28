<div>
    <form wire:submit="update">
        @csrf
        
        <input 
            class="hidden" 
            wire:model.fill="federation_id"
            type="text" name="federation_id"
            />

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="code">
                {{ _('Section Shortcode') }}
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
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('Section name') }}
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
            <style>textarea {resize:vertical;}</style>
            <label class="block font-medium text-sm text-gray-700" for="name">
                {{ __('Section definition') }}
            </label>
            <textarea 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="excerptum"
                wire:model.live.debounce.500ms="excerptum"
            ></textarea>
            @error('excerptum')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>

    </form>
</div>
