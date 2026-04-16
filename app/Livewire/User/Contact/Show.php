<?php

/**
 * Simply show all data of user contacts
 *
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Show extends Component
{
    public UserContact $userContact;

    public function mount(UserContact $userContact = null) // from route, parm can miss
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        if ($userContact) {
            $this->userContact = $userContact;
        } else {
            $this->userContact = UserContact::where('id', Auth::id())->first();
        }
    }

    public function render()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return view('livewire.user.contact.show');
    }
}
