<div>
    <!-- header -->
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
            {{ __('Cellular international Id (like +393101234567) is facultative, but ') }}
            {{ __('sometimes needed to resolve trouble when email are stopped for any reason.') }}
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

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="text-red-600">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form wire:submit="updateUserContact3rd">
        @csrf

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="cellular">
                {{ __('Cellular international number') }}
                | {{ __('facultative') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="tel" name="cellular"
                wire:model.live.debounce.500ms="cellular" 
                aria-describedby="cellularHelp"
            />
            <div class="small" id="cellularHelp">{{ __('Only digit prefixed by +country_code, we use for text messages.') }}</div>
            <div class="text-white bg-red-600 small">@error('cellular') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="fyk block font-medium text-2xl text-gray-700" for="whatsapp">
                {{ __('Whatsapp contact url') }}
                | {{ __('facultative') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="whatsapp"
                wire:model.live.debounce.500ms="whatsapp" 
            />
            <div class="text-white bg-red-600 small">@error('whatsapp') {{ $message }} @enderror</div>
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
