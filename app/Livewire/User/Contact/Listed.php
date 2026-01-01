<?php

/**
 * Simply show all data of user contacts
 */

namespace App\Livewire\User\Contact;

use App\Models\Country;
use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Listed extends Component
{
    public string $user_id;

    public $user_contact;

    public $country;

    public function mount()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $this->user_id = Auth::id();
        $this->user_contact = UserContact::where('user_id', $this->user_id)->first();
        $this->country = Country::where('id', $this->user_contact->country_id)->first();
    }

    public function render()
    {
        Log::info('Component '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return view('livewire.user.contact.listed');
    }
}
