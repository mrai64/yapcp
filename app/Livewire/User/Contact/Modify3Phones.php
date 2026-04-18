<?php

/**
 * UserContact modify 3 - cellular sms whatsapp
 *
 * TODO add field whatsapp_reachable, wechat_reachable instead of whatsapp field issue #121
 * TODO see also `composer require propaganistas/laravel-phone`
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
    public function mount(?UserContact $userContact = null) // as route
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
        ->route('user-contact.modify4', ['userContact' => $this->userContact])
        ->with('success', __("Cellular and Whatsapp updated successfully."));
    }
}
