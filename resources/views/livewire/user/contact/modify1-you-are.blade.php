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
    <h3 class="fyk text-xl mb-4"><em>{{ __("You are...")}}</em></h3>    

    <form wire:submit="update_user_contact" enctype="multipart/form-data">
        @csrf

        <div class="mb-4" data-yapcp="first_name">
            <label class="fyk block font-medium text-2xl text-gray-700" for="first_name">
                {{ __('First name | required') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="first_name"
                wire:model.live.debounce.500ms="first_name" 
                required="required" 
            />
            <div class="small">{{ __("Min 2 char") }}</div>
            <div class="text-white bg-red-600 small">@error('first_name') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4" data-yapcp="last_name">
            <label class="fyk block font-medium text-2xl text-gray-700" for="last_name">
                {{ __('Last / Family name | required') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="last_name"
                wire:model.live.debounce.500ms="last_name" 
                required="required" 
            />
            <div class="small">{{ __("Min 2 char") }}</div>
            <div class="text-white bg-red-600 small">@error('last_name') {{ $message }} @enderror</div>
        </div>

        <!-- From country -->
        <div class="mb-4" data-yapcp="country_id">
            <label class="fyk block font-medium text-2xl text-gray-700" for="country_id">
                {{ __('From Country | required') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live="country_id"
                name="country_id" 
                required="required"
                >
                <option value="">{{ __("...") }}</option>
                @foreach ($countries as $country)
                <option value="{{ trim($country->id) }}" {{ ($country->id === $country_id ) ? 'selected' : '' }}>{{$country->flag_code}} {{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">{{ __("In alphabetical order") }}</div>
            <div class="text-white bg-red-600 small">@error('country_id') {{ $message }} @enderror</div>
        </div>
        <!-- passport photo upload -->
        <div class="block mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="passport_photo_image">
                {{ __('Passport Photo | facultative') }}
            </label>
        @if ($passport_photo_image)
            <img src="{{ $passport_photo_image->temporaryUrl() }}" style="float: left;" class="block w-48 me-3" />
        @else
            <img src="{{ asset('storage/photos') . '/' . $passport_photo }}" alt="" style="float: left;" class="block w-48 me-3">
        @endif
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1" 
                type="file" accept="image/jpeg"
                name="passport_photo_image" wire:model="passport_photo_image"
                aria-describedby="photoHelp"
            />
            <div wire:loading wire:target="passport_photo_image">{{ __("Uploading...")}}</div>
            <div class="small" id="photoHelp">{{ __("Just a little 'passport' photo, it's facultative (near 414pxH x 532pxV)") }}</div>
            <div class="text-white bg-red-600 small">@error('passport_photo_image') {{ $message }} @enderror</div>
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
