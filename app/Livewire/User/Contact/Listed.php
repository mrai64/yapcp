<?php

/**
 * admin only
 *
 * the paged list of users for all platform
 *
 */

namespace App\Livewire\User\Contact;

use App\Models\UserContact;
use Livewire\Component;
use Livewire\WithPagination;

class Listed extends Component
{
    use WithPagination;

    // no mount()

    public function render()
    {
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        $userContactSet = UserContact::query()
            ->orderBy('country_id', 'asc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->orderBy('created_at', 'asc')
            ->simplePaginate(20);
        // ->get();
        ds('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' res: ' 
            . json_encode($userContactSet));

        return view('livewire.user.contact.listed', [
            'userContactSet' => $userContactSet
        ]);
    }
}
