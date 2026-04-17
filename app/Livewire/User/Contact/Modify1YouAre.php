<?php

/**
 * userContact modify 1 of 5 - personal data
 * Should be used form admin and user to modify personal data
 *
 * 2026-01-25 When name == surname and a comma is in the between
 *
 * @see /resources/views/livewire/user/contact/modify1-you-are.blade.php
 */

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Modify1YouAre extends Component
{
    use WithFileUploads;

    public UserContact $userContact;

    public $allCountriesSet;

    // form fields
    public string $firstName;

    public string $lastName;

    public string $countryId;

    public string $passportPhoto;

    public $passportPhotoImage;

    // 1. mount
    public function mount(?UserContact $userContact = null) // facultative route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        if ($userContact === null) {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' no parm');
            $uid = Auth::id(); // user id
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uid: ' . $uid);
            $this->userContact = UserContact::where('id', $uid)->first();
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uC: ' . json_encode($this->userContact));
        } else {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' parm');
            $this->userContact = $userContact;
        }

        // form fields
        $this->firstName = $this->userContact->first_name;
        $this->lastName = $this->userContact->last_name;
        // when inserted from user creation - when both are 'Surname, Name'
        if (($this->firstName == $this->lastName) && (stripos($this->lastName, ',') > 0)) {
            [$this->lastName, $this->firstName] = explode(',', $this->lastName);
            $this->lastName = trim($this->lastName);
            $this->firstName = trim($this->firstName);
        }
        // default value ITA as first developer he's italian 
        $this->countryId = ($this->userContact->country_id ?? 'ITA');
        // countries list
        $this->allCountriesSet = Country::select(['id', 'country', 'flag_code'])
            ->orderBy('country')
            ->get();
        // passport photo
        $this->passportPhoto = $this->userContact->passport_photo ?? '';
        $this->passportPhotoImage = null;
    }

    // 2. render
    public function render()
    {
        return view('livewire.user.contact.modify1-you-are');
    }

    // 3. validation rules
    protected function rules()
    {
        return [
            'firstName' => 'required|string|min:2|max:255',
            'lastName' => 'required|string|min:2|max:255',
            'countryId' => 'required|string|exists:countries,id',
            'passportPhoto' => 'nullable|string|max:255',
            'passportPhotoImage' => 'nullable|image|mimes:jpg|max:2048',
        ];
    }

    // 4. update
    // was: update_user_contact
    public function updateUserContact1st()
    {
        $validated = $this->validate();

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
            $passportPhotoFilename .= '/__passport.photo.jpg';

            // stored in...
            $this->passportPhotoImage->storeAs('photos', $passportPhotoFilename, 'public');

            $this->userContact->passport_photo = $passportPhotoFilename;
        }

        $this->userContact->save();

        return redirect()
            ->route('user-contact.modify2', ['uid' => $this->userContact->user_id])
            ->with('success', __("Name, Country n Pass photo updated successfully"));
    }
}
