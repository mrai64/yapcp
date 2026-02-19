<div>
    <!-- header -->
    <h2 class="fyk text-2xl mb-4">{{ __('Update your personal info') }}</h2>
    <p class="small">{{ __("We use these info for your next Contest.")}} </p>
    <hr class="my-4" />
    <br />
    <br />

    @if ($errors->any())
    <div>
        <ul>
            @foreach ($errors->all() as $error)
                <li class="alert alert-danger small">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- nav bar here -->

    <form wire:submit="updateUserContact" enctype="multipart/form-data">
        @csrf
        <!-- readonly -->
        <div class="mb-4" data-yapcp="email">
            <label class="block font-medium text-sm text-gray-700" for="email">
                {{ __('yaPCP Verified Email') }} | 🔒
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="email" name="email"
                wire:model.live.debounce.500ms="email" 
                readonly
            />
            <div class="small" id="cellularHelp">{{ __('Your email n password are key to entry.') }}</div>
            <div class="small">@error('email') {{ $message }} @enderror</div>
        </div>
        <div class="mb-4" data-yapcp="userId">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="userId">
                {{ __('yaPCP assigned ID') }} | 🔒
            </label>
            <input 
                class="text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="userId" 
                wire:model.fill="userId"
                readonly
                />
            <div class="small" id="cellularHelp">{{ __("Your ID in yaPCP") }}</div>
            <div class="alert alert-danger small">@error('userId') {{ $message }} @enderror</div>
        </div>
        <br />
        <hr class="my-4" />
        <br />
        <!-- 1st fieldset Name, last Name, country -->
        <h3 class="fyk text-2xl mb-4">{{ __("🤵‍♀️ 🤵‍♂️ You are...") }}</h3>
        <div class="mb-4" data-yapcp="firstName">
            <label class="block font-medium text-sm text-gray-700" for="firstName">
                {{ __('First name') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="firstName"
                wire:model.live.debounce.500ms="firstName" 
                required="required" 
            />
            <div class="small">@error('firstName') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4" data-yapcp="lastName">
            <label class="block font-medium text-sm text-gray-700" for="lastName">
                {{ __('Last name') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="lastName"
                wire:model.live.debounce.500ms="lastName" 
                required="required" 
            />
            <div class="small">@error('lastName') {{ $message }} @enderror</div>
        </div>
        <!-- From country -->
        <div class="mb-4" data-yapcp="countryId">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="countryId">
                {{ __('From Country') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model.live="countryId"
                name="countryId" 
                required="required"
                >
                @foreach ($countries as $country)
                <option value="{{ trim($country->id) }}" {{ ($country->id === $countryId ) ? 'selected' : '' }}>{{ $country->country }}</option>
                @endforeach
            </select>
            <div class="small">@error('countryId') {{ $message }} @enderror</div>
        </div>
        <!-- passport photo upload -->
        <div class="block mb-4">
            <label class="block font-medium text-sm text-gray-700" for="passportPhotoImage">
                {{ __('Passport Photo') }}
            </label>
            @if ($passportPhotoImage)
            <img src="{{ $passportPhotoImage->temporaryUrl() }}" style="float: left;" class="block w-48 me-3" />
            @else
            <img src="{{ asset('storage/photos') . '/' . $passport_photo }}" alt="" style="float: left;" class="block w-48 me-3">
            @endif
            <input 
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1" 
            type="file" accept="image/jpeg"
            name="passportPhotoImage" wire:model="passportPhotoImage"
            aria-describedby="photoHelp"
            />
            <div wire:loading wire:target="passportPhotoImage">Uploading...</div>
            <div class="small" id="photoHelp">{{ __('Jpg only, Better 480px w 640px h max 2 MBi') }}</div>
            <div class="small">@error('passportPhotoImage') {{ $message }} @enderror</div>
        </div>
        <br style="clear:both;" />
        <br />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>

        <br />
        <br />
        <hr class="my-4" /> 
        <h3 class="fyk text-2xl">{{ __("📨 International Posta address")}}</h3>
        <p class="small mb-4">{{ __('Contest organizer need your postal address to send you the prizes if you win. Please be accurate.') }}</p>
        <div class="mt-4 mb-4">
            <label class="block font-medium text-sm text-gray-700" for="address">
                {{ __('Address') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="address"
                wire:model.live.debounce.500ms="address" 
            />
            <div class="small">@error('address') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="address2ndLine">
                {{ __('Address 2nd line') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="address2ndLine"
                wire:model.live.debounce.500ms="address2ndLine" 
            />
            <div class="small">@error('address2ndLine') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="city">
                {{ __('City') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="city"
                wire:model.live.debounce.500ms="city" 
            />
            <div class="small">@error('city') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="region">
                {{ __('Region') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="region"
                wire:model.live.debounce.500ms="region" 
            />
            <div class="small">@error('region') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="postalCode">
                {{ __('Postal code') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-48" 
                type="text" name="postalCode"
                wire:model.live.debounce.500ms="postalCode" 
            />
            <div class="small">@error('postalCode') {{ $message }} @enderror</div>
        </div>
        <br />
        <hr class="my-4" />
        <h3 class="fyk text-2xl mb-4">{{ __("💻💬 Other way to contact you")}}</h3>
        <p class="small">{{ __("Facultative, sometimes useful")}}</p>
        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="website">
                {{ __('website') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="website"
                wire:model.live.debounce.500ms="website" 
            />
            <div class="small">@error('website') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="facebook">
                {{ __('Facebook') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="facebook"
                wire:model.live.debounce.500ms="facebook" 
            />
            <div class="small">@error('facebook') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="exTwitter">
                {{ __('X was Twitter') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="exTwitter"
                wire:model.live.debounce.500ms="exTwitter" 
            />
            <div class="small">@error('exTwitter') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="instagram">
                {{ __('Instagram page') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="instagram"
                wire:model.live.debounce.500ms="instagram" 
            />
            <div class="small">@error('instagram') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="whatsapp">
                {{ __('Whatsapp') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="whatsapp"
                wire:model.live.debounce.500ms="whatsapp" 
            />
            <div class="small">@error('whatsapp') {{ $message }} @enderror</div>
        </div>

        <br />
        <hr class="my-4" />
        <h3 class="fyk text-2xl mb-4">{{ __("🌍 Additional fields required from Federations")}}</h3>
        <p class="small mb-4">{{ __('These fields are additional info required from important for correct localization of your account.') }}</p>

        <!-- refactor-->  
        <div class="mb-4" data-yapcp="nickname">
            <label class="block font-medium text-sm text-gray-700" for="nick_name">
                {{ __('Nickname') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="text" name="nick_name"
                wire:model.live.debounce.500ms="nick_name" 
            />
            <div class="small">@error('nick_name') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="block font-medium text-sm text-gray-700" for="cellular">
                {{ __('Cellular international number') }}
            </label>
            <input 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                type="tel" name="cellular"
                wire:model.live.debounce.500ms="cellular" 
                aria-describedby="cellularHelp"
            />
            <div class="small" id="cellularHelp">{{ __('Insert phone number even with international code, but without plus/+ or leading zeroes.') }}</div>
            <div class="small">@error('cellular') {{ $message }} @enderror</div>
        </div>

        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" for="localLang">
                {{ __('Language code (for future use)') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" 
                wire:model="localLang"
                name="localLang" 
                required="required
                >
                @foreach ($langSet as $lang_code => $lang_lang)
                <option value="{{ $lang_code }}" {{($lang_code == $localLang) ? 'selected' : '' }} > {{ $lang_lang }}</option>
                @endforeach
            </select>
            <div class="small">{{ __('When * marked, we need help to complete i18n. Help us.')}}</div>
            <div class="small">@error('localLang') {{ $message }} @enderror</div>
        </div>

        <!-- timezone -->
        <div class="mb-4">
            <label class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-auto max-w-7xl" for="localTimezone">
                {{ __('Timezone') }}
            </label>
            <select 
                class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                wire:model="localTimezone"
                name="localTimezone" 
                required="required"
                >
                @foreach ($timezoneList as $k => $tzItem)
                <option value="{{ $tzItem['id'] }}" {{ ($tzItem['id'] == $timezone) ? 'selected' : '' }}> {{ $tzItem['id'] }} </option>
                @endforeach
            </select>
            <div class="small">{{ __('As worldwide platform we need to manage correctly time.') }} {{ __('List is in alphabetically order A>Z') }}</div>
            <div class="small">@error('localTimezone') {{ $message }} @enderror</div>
        </div>



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="alert alert-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <hr />

        <button type="submit" 
            class="inline-flex items-center px-4 py-2 m-0 mt-4 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 ms-3"
            >
            {{ __('Update') }}
        </button>

    </form>
</div>
