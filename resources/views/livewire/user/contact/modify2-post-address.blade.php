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
    <div class="fyk block font-medium text-2xl text-gray-700 mb-4">
        {{$country->flag_code}} | {{ $last_name}}, {{ $first_name }}
    </div>
    <h3 class="fyk text-xl mb-4"><em>{{ __("Where do you live...")}}</em></h3>    
    <form wire:submit="update_user_post_address">
        @csrf

        
        <p class="small mb-4">{{ __('Contest organizer need your postal address to send you the prizes if you win. Please be accurate.') }}</p>
        <div class="mt-4 mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="address">
                {{ __('Address') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="address"
                wire:model.live.debounce.500ms="address" 
            />
            <div class="text-white bg-red-600 small">@error('address') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="address_line2">
                {{ __('Address 2nd line') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="address_line2"
                wire:model.live.debounce.500ms="address_line2" 
            />
            <div class="text-white bg-red-600 small">@error('address_line2') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="city">
                {{ __('City') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="city"
                wire:model.live.debounce.500ms="city" 
            />
            <div class="text-white bg-red-600 small">@error('city') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="region">
                {{ __('Region') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="region"
                wire:model.live.debounce.500ms="region" 
            />
            <div class="text-white bg-red-600 small">@error('region') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="postal_code">
                {{ __('Postal code') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="postal_code"
                wire:model.live.debounce.500ms="postal_code" 
            />
            <div class="text-white bg-red-600 small">@error('postal_code') {{ $message }} @enderror</div>
        </div>
        <br style="clear:both;" />
        <br />

        <p>&nbsp;</p>
        <button type="submit" 
            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update, then next panel') }}
        </button>
    </form>
</div>
