<?php

/**
 * UserContact modify 3 - cellular sms whatsapp
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Modify3Phones extends Component
{
    public $user_contact;

    public $country;

    // fields
    public string $first_name;

    public string $last_name;

    public string $country_id;

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

        $this->user_contact = UserContact::where('user_id', $uid)->first();
        // form fields
        $this->first_name = $this->user_contact->first_name;
        $this->last_name = $this->user_contact->last_name;
        $this->country_id = ($this->user_contact->country_id ?? '***');
        $this->country = ($this->user_contact->country ?? null);

        $this->cellular = $this->user_contact->cellular ?? '';
        $this->whatsapp = $this->user_contact->whatsapp ?? 'https://wa.me/';

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
    public function update_user_phones()
    {
        $this->user_contact->cellular = $this->cellular;
        $this->user_contact->whatsapp = $this->whatsapp;

        $this->user_contact->save();

        return redirect()
            ->with('success', __("'Cellular and Whatsapp updated successfully.'"))
            ->route('user-contact-modify4', ['uid' => $this->user_contact->user_id]);

    }
}
