<?php

/**
 * UserContact modify 3 - cellular sms whatsapp
 * 
 * TODO see also `composer require propaganistas/laravel-phone`
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify3Phones extends Component
{
    public $userContact;

    public $country;

    // fields
    public string $firstName;

    public string $lastName;

    public string $countryId;

    public string $cellular;

    public string $whatsapp;

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
        $this->firstName = $this->userContact->firstName;
        $this->lastName = $this->userContact->last_name;
        $this->countryId = ($this->userContact->country_id ?? '***');
        $this->country = ($this->userContact->country ?? null);

        $this->cellular = $this->userContact->cellular ?? '';
        $this->whatsapp = $this->userContact->whatsapp ?? 'https://wa.me/';

    }

    // 2. render
    public function render()
    {
        return view('livewire.user.contact.modify3-phones');
    }

    // 3. validation rules
    protected function rules()
    {
        return [
            'cellular' => 'integer|min_digits:6|max_digits:14|min:1',
            'whatsapp' => 'string|active_url|max:30',
        ];
    }

    // 4. update
    // was: update_user_phones
    public function updateUserContact3rd()
    {
        $this->userContact->cellular = $this->cellular;
        $this->userContact->whatsapp = $this->whatsapp;

        $this->userContact->save();

        return redirect()
            ->with('success', __("'Cellular and Whatsapp updated successfully.'"))
            ->route('user-contact-modify4', ['uid' => $this->userContact->user_id]);

    }
}
