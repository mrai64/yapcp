<?php

/**
 * User Observer
 * When User is created
 */

namespace App\Observers;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // build a UserContact record
        if (Str::contains(', ', $user->name, true)) {
            [$lastName, $firstName] = explode(', ', $user->name);
        } else {
            $lastName = $user->name;
            $firstName = $user->name;
        }
        UserContact::create([
            'id' => $user->id,
            'last_name' => $lastName,
            'first_name' => $firstName,
            'country_id' => '',
            'email' => $user->email,
        ]);
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        // update UserContact record
        if ($user->isDirty('email')) {
            UserContact::withTrashed()
                ->where('id', $user->id)
                ->update(['email' => $user->email]);
        }
    }

    /**
     * Handle the User "deleted" event.
     */
    public function deleted(User $user): void
    {
        //
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
