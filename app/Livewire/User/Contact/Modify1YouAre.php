<?php

/**
 * userContact modify 1 - personal data
 * Should be used form admin and user to modify personal data
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

    public $user_contact;

    public string $first_name;

    public string $last_name;

    public string $country_id;

    public $countries;

    public string $passport_photo;

    public $passport_photo_image;

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
        $this->user_contact = UserContact::where('user_id', $uid)->first();
        // form fields
        $this->first_name = $this->user_contact->first_name;
        $this->last_name = $this->user_contact->last_name;
        $this->country_id = ($this->user_contact->country_id ?? '***');

        $this->countries = Country::select(['id', 'country', 'flag_code'])->orderBy('country')->get();

        $this->passport_photo = $this->user_contact->passport_photo ?? '';

        $this->passport_photo_image = null;
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
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'passport_photo' => 'nullable|string|max:255',
            'passport_photo_image' => 'nullable|image|mimes:jpg|max:2048',
        ];
    }

    // 4. update
    public function update_user_contact()
    {
        $this->validate();

        $this->user_contact->first_name = $this->first_name;
        $this->user_contact->last_name = $this->last_name;
        $this->user_contact->country_id = $this->country_id;

        // passport photo upload
        if (! is_null($this->passport_photo_image)) {
            // stored as...
            $passport_photo_name = $this->user_contact->photo_box();
            $passport_photo_name = str_ireplace(':', '-', $passport_photo_name);
            $passport_photo_name = str_ireplace('+', '', $passport_photo_name);
            $passport_photo_name = str_ireplace(' ', '-', $passport_photo_name);
            $passport_photo_name .= '/__passport.photo.jpg';
            // stored in...
            $this->passport_photo_image->storeAs('photos', $passport_photo_name, 'public');
            $this->user_contact->passport_photo = $passport_photo_name;
        }

        $this->user_contact->save();

        return redirect()
            ->with('success', __("'Name, Country n Pass photo updated successfully.'"))
            ->route('user-contact-modify2', ['uid' => $this->user_contact->user_id]);

    }
}
