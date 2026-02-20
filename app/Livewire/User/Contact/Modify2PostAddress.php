<?php

/**
 * UserContact modify 2 - postal address
 * Should be used form admin and user to modify postal address
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify2PostAddress extends Component
{
    public $userContact;

    public $country;

    // fields
    public string $firstName;

    public string $lastName;

    public string $countryId;

    public string $address;

    public string $addressLine2;

    public string $city;

    public string $region;

    public string $postalCode;

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

        $this->userContact = UserContact::where('id', $uid)->first();
        ds($this->userContact);

        // form fields
        $this->firstName = $this->userContact->first_name; // name
        $this->lastName = $this->userContact->last_name; //   surname

        $this->countryId = ($this->userContact->country_id ?? '***'); // used?
        $this->country = $this->userContact->country; //       nationality

        $this->address = $this->userContact->address ?? 'insert address';
        $this->addressLine2 = $this->userContact->addressLine2 ?? '';
        $this->city = $this->userContact->city ?? ''; //       municipality
        $this->region = $this->userContact->region ?? ''; //
        $this->postalCode = $this->userContact->postal_code ?? '';
    }

    // 2. render
    public function render()
    {
        return view('livewire.user.contact.modify2-post-address');
    }

    // 3. validate
    public function rules()
    {
        return [
            'address' => 'required|string|max:255',
            'addressLine2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'region' => 'nullable|string|max:100',
            'postalCode' => 'required|string|max:10',
        ];
    }

    // 4. save
    // was: update_user_post_address
    public function updateUserContact2nd()
    {
        $validated = $this->validate();

        $this->userContact->address = $validated['address'];
        $this->userContact->address_line2 = $validated['addressLine2'];
        $this->userContact->city = $validated['city'];
        $this->userContact->region = $validated['region'];
        $this->userContact->postal_code = $validated['postalCode'];

        $this->userContact->save();

        return redirect()
            ->with('success', __("'Postal address updated successfully.'"))
            ->route('user-contact-modify3', ['uid' => $this->userContact->user_id]);
    }
}
