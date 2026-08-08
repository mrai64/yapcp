<?php

namespace App\Observers;

use App\Models\UserWork;
use App\Notifications\WorkUpdatedNotification;

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
        $userWork->user->notify(new WorkUpdatedNotification($userWork));
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
