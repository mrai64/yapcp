<div>
    <p class="mb-4">Well, New Federation? Insert few data here.</p>
    <p class="mb-4">Wanna check 
        <a href="{{ route('federation-list') }}" 
            target="_blank" rel="noopener noreferrer">
        Federation list 
        </a>?
    </p>
    <form wire:submit="save">
        @csrf 

        <!-- Federation name -->
        <div>
        <label class="block font-medium text-sm text-gray-700" for="name">
            Federation Name
        </label>
        <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            type="text" 
            wire:model="name" 
            value="{{ old('name') }}"
            required="required" 
            />
            @error('name')
            <div class="alert alert-danger small">{{ $message }} </div>
            @enderror
        </div>
        
        <div>
            <label class="block font-medium text-sm text-gray-700" for="code">
                Federation Shortcode
            </label>
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
            wire:model="code" type="text" name="code" 
            value="{{ old('code') }}"
            required="required" 
            />
            <div class="small">@error('code') {{ $message }} @enderror</div>
        </div>
        
        <div>
            <label class="block font-medium text-sm text-gray-700" for="website">
                Official website
            </label>
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
            wire:model="website" 
            type="text" name="website" 
            value="{{ old('website') }}"
            >
            <div class="small">@error('website') {{ $message }} @enderror</div>
        </div>

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            Add
        </button>

        </div>
    </form>
</div>
