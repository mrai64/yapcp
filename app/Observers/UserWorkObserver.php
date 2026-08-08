<?php

namespace App\Observers;

use App\Models\UserWork;
use App\Mail\WorkUpdatedNotification;
use Illuminate\Support\Facades\Mail;

class UserWorkObserver
{
    /**
     * Handle the UserWork "created" event.
     */
    public function created(UserWork $userWork): void
    {
        //
    }

    /**
     * Handle the UserWork "updated" event.
     */
    public function updated(UserWork $userWork): void
    {
        // to:
        $user = $userWork->userContact->user();

        if ($user) {
            // send notify
            $user->notify(new WorkUpdatedNotification($userWork));
        }
    }

    /**
     * Handle the UserWork "deleted" event.
     */
    public function deleted(UserWork $userWork): void
    {
        //
    }

    /**
     * Handle the UserWork "restored" event.
     */
    public function restored(UserWork $userWork): void
    {
        //
    }

    /**
     * Handle the UserWork "force deleted" event.
     */
    public function forceDeleted(UserWork $userWork): void
    {
        //
    }
}
