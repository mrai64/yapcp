<?php

/**
 * User Contact modify 1st of five
 * 
 */

use Livewire\Volt\Component;
use App\Models\UserContact;
use App\Models\Country;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\WithFileUploads;

new class extends Component {

    use WithFileUploads;

    public UserContact $userContact;

    public $firstName;

    public $lastName;

    public $countryId;

    public $passportPhoto;

    public $passportPhotoImage;

    public $allCountriesSet;

    // mount() yes
    // render() no
    // with() no 
    public function mount(UserContact $user_contact)
    {
        $this->userContact = $user_contact;
        $this->allCountriesSet = Country::all();
        $this->firstName = $user_contact->first_name ?? 'N\A';
        $this->lastName = $user_contact->last_name ?? 'N\A';
        $this->countryId = $user_contact->country_id ?? 'ITA';
        $this->passportPhoto = $user_contact->passport_photo ?? '';
        $this->passportPhotoImage = null; // Storage::url( $user_contact->photoBox() . '/__passport_photo.jpg' );
    }

    // validate rules
    // passportPhoto is a path + namefile
    // passportPhotoImage is a file loaded by blade
    public function rules(): array
    {
        return [
            'firstName'          => 'required|string|min:2|max:255',
            'lastName'           => 'required|string|min:2|max:255',
            'countryId'          => 'required|string|exists:countries,id',
            'passportPhoto'      => 'nullable|string|max:255',
            'passportPhotoImage' => 'nullable|image|mimes:jpg|max:512',
        ];
    }

    // form validation and update
    public function updateUserContact1st()
    {
        $validated = $this->validate();

        // not update() because passportPhoto require a bit of sw
        $this->userContact->first_name = $validated['firstName'];
        $this->userContact->last_name = $validated['lastName'];
        $this->userContact->country_id = $validated['countryId'];

        // passport photo upload
        if (! is_null($this->passportPhotoImage)) {
            // stored as...
            $passportPhotoFilename = $this->userContact->photoBox();
            $passportPhotoFilename = str_ireplace(':', '-', $passportPhotoFilename);
            $passportPhotoFilename = str_ireplace('+', '', $passportPhotoFilename);
            $passportPhotoFilename = str_ireplace(' ', '-', $passportPhotoFilename);
            $passportPhotoFilename .= '/__passport_photo.jpg';

            // stored in...
            $this->passportPhotoImage->storeAs('photos', $passportPhotoFilename, 'public');

            $this->userContact->passport_photo = $passportPhotoFilename;
        }

        $this->userContact->save();

        return redirect()
            ->route('user.contact.modify2', ['user_contact' => $this->userContact])
            ->with('success', __("Name, Country n Pass photo updated successfully"));

    }

}; ?>

<div>
    <x-slot name="header">
        <h2 class="fyk text-2xl font-medium text-gray-900">
            {{ __(':name, Your personal info / 1st of five', ['name' => $userContact->first_name] ) }}
        </h2>
        <hr class="mb-4" />
        <livewire:user.contact.modify-nav :user_contact="$userContact" />
        <hr class="mb-2" />
        <x-yapcp.header-link 
            txt="Back to dashboard" 
            url="{{ route('user.dashboard') }}" />


    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
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
                        <li class="text-red-600">❌ {{ $error }} 👈</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form wire:submit="updateUserContact1st">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="firstName" :value="__('First name')" />
                        <x-text-input wire:model="firstName" id="firstName" class="block mt-1 w-full" type="text" name="firstName" required />
                        <x-input-error for="firstName" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="lastName" :value="__('Last name, Surname')" />
                        <x-text-input wire:model="lastName" id="lastName" class="block mt-1 w-full" type="text" name="lastName" required placeholder="{{ __('last name') }}"/>
                        <x-input-error for="lastName" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="countryId" :value="__('Nation, Country')" />
                        <select 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" 
                            wire:model="countryId"
                            name="countryId" 
                            required >
                            <option value="">{{ __("...") }}</option>
                            @foreach ($allCountriesSet as $country)
                            <option value="{{ trim($country->id) }}" {{ ($country->id === $countryId ) ? 'selected' : '' }}>{{$country->flag_code}} {{ $country->country }}</option>
                            @endforeach
                        </select>
                        <x-input-error for="countryId" class="mt-2" />
                    </div>

                    <!-- say cheese -->

                    <!-- passport photo upload -->
                    <div class="block mb-4">
                        <x-input-label for="passportPhotoImage" :value="__('Passport photo, facultative')" />

                        @if ($passportPhotoImage)
                        <img src="{{ $passportPhotoImage->temporaryUrl() }}" style="float: left;" class="block w-48 me-3" />
                        <br style="clear:both;" />
                        @else
                        <img src="{{ asset('storage/photos') . '/' . $passportPhoto }}" 
                            alt="" style="float: left;" class="block w-48 me-3" />
                        <br style="clear:both;" />
                        @endif
    
                        <input 
                            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1" 
                            type="file" accept="image/jpeg"
                            name="passportPhotoImage" wire:model="passportPhotoImage"
                            aria-describedby="photoHelp" />
                        <div wire:loading wire:target="passportPhotoImage">{{ __("Uploading...")}}</div>
                        <div class="small" id="photoHelp">
                            {{ __("Just a little 'passport' photo, near 420 px * 520 px, max .5MB") }}
                        </div>
                        <x-input-error for="passportPhotoImage" class="mt-2" />
                    </div>

                    <br style="clear:both;" />

                    <x-button class="mt-2 ms-4">
                        {{ __('Update, then next panel') }}
                    </x-button>

                </form>
            </div>
        </div>
    </div>
    <!-- -->
    <x-footer-app />
</div>
