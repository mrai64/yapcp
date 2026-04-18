<?php

/**
 * UserContact modify 2 of 5 - postal address
 * Should be used by admin and user herself/himself for postal address
 * 
 * @see /resources/views/livewire/user/contact/modify2-post-address.blade.php
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    public function mount(?UserContact $userContact = null) // from route, facultative
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
        $this->firstName = $this->userContact->first_name; // name         readonly
        $this->lastName = $this->userContact->last_name; //   surname      readonly
        // default value ITA as first developer he's italian 
        $this->countryId = ($this->userContact->country_id ?? 'ITA');
        $this->country = $this->userContact->country; //      nationality  readonly

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
            ->route('user-contact.modify3', ['userContact' => $this->userContact])
            ->with('success', __("Postal address updated successfully"));
    }
}
