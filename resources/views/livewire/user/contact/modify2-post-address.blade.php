<div>
    <header>
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __('Update your personal info') }}
        </h2>
    <!-- nav bar here -->
        <h3 class="fyk text-2xl font-medium text-gray-900">
            {{$lastName}}, {{ $firstName }} | {{$userContact->country->flag_code}} {{$userContact->country->country}}
        </h3>
        <h3 class="fyk text-xl font-medium text-gray-900">
            <em>{{ __("2nd of 5 | Where are you...")}}</em>
        </h3>
        <p class="small mb-4">
            {{ __('Contest organizer need your postal address to send you the prizes if you win.') }}
            {{ __('Use the international postal address standard, with latin character.') }}
        </p>
        <hr />
        <br />
        <p class="fyk text-xl font-medium mb-4">
            <a  href="{{ route('user.dashboard') }}"
                rel="noopener noreferrer">
            [ {{ __('Back to dashboard') }} ]
            </a>
        </p>
    </header>

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
                <li class="text-red-600">❌ {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form wire:submit="updateUserContact2nd">
        @csrf

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
            <label class="fyk block font-medium text-2xl text-gray-700" for="addressLine2">
                {{ __('Address 2nd line') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="addressLine2"
                wire:model.live.debounce.500ms="addressLine2" 
            />
            <div class="text-white bg-red-600 small">@error('addressLine2') {{ $message }} @enderror</div>
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
            <label class="fyk block font-medium text-2xl text-gray-700" for="postalCode">
                {{ __('Postal code') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="postalCode"
                wire:model.live.debounce.500ms="postalCode" 
            />
            <div class="text-white bg-red-600 small">@error('postalCode') {{ $message }} @enderror</div>
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
