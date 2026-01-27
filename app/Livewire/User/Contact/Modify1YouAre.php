<?php

/**
 * userContact modify 1 - personal data
 * Should be used form admin and user to modify personal data
 *
 * 2026-01-25 When name == surname and a comma is in the between
 */

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Modify1YouAre extends Component
{
    use WithFileUploads;

    public $userContact;

    public $countries;

    // form fields
    public string $firstName;

    public string $lastName;

    public string $countryId;

    public string $passportPhoto;

    public $passportPhotoImage;

    // 1. mount
    public function mount(?string $uid = '')
    {
        if ($uid === '') {
            $uid = Auth::id();
        }

        // if uid is not Auth::id(), auth::id() must be in user_admins.id
        // otherwise -and temporary- abort 403
        if ($uid != Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $this->userContact = UserContact::where('user_id', $uid)->first();
        // form fields
        $this->firstName = $this->userContact->first_name;
        $this->lastName = $this->userContact->last_name;
        // first time modify, when Surname, Name
        if (($this->firstName == $this->lastName) && (stripos($this->lastName, ',') > 0)) {
            [$this->lastName, $this->firstName] = explode(',', $this->lastName);
            $this->lastName = trim($this->lastName);
            $this->firstName = trim($this->firstName);
        }

        $this->countryId = ($this->userContact->country_id ?? '***');

        $this->countries = Country::select(['id', 'country', 'flag_code'])->orderBy('country')->get();

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
            ->with('success', __("'Name, Country n Pass photo updated successfully.'"))
            ->route('user-contact-modify2', ['uid' => $this->userContact->user_id]);

    }
}
