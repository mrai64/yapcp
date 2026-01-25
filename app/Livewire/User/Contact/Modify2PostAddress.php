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
    public $user_contact;

    public $country;

    // fields
    public string $first_name;

    public string $last_name;

    public string $country_id;

    public string $address;

    public string $address_line2;

    public string $city;

    public string $region;

    public string $postal_code;

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
        ds($this->user_contact);

        // form fields
        $this->first_name = $this->user_contact->first_name; // name
        $this->last_name = $this->user_contact->last_name; //   surname

        $this->country_id = ($this->user_contact->country_id ?? '***');
        $this->country = $this->user_contact->country; //       nationality

        $this->address = $this->user_contact->address ?? 'insert address';
        $this->address_line2 = $this->user_contact->address_line2 ?? '';
        $this->city = $this->user_contact->city ?? ''; //       municipality
        $this->region = $this->user_contact->region ?? ''; //   
        $this->postal_code = $this->user_contact->postal_code ?? '';
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
            'address_line2' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'region' => 'nullable|string|max:100',
            'postal_code' => 'required|string|max:10',
        ];
    }

    // 4. save
    public function update_user_post_address()
    {
        $this->validate();

        $this->user_contact->address = $this->address;
        $this->user_contact->address_line2 = $this->address_line2;
        $this->user_contact->city = $this->city;
        $this->user_contact->region = $this->region;
        $this->user_contact->postal_code = $this->postal_code;

        $this->user_contact->save();

        return redirect()
            ->with('success', __("'Postal address updated successfully.'"))
            ->route('user-contact-modify3', ['uid' => $this->user_contact->user_id]);
    }
}
