<?php

namespace App\Listeners;

use App\Events\UserEmailVerified;
use App\Models\UserContact;
use Illuminate\Support\Str;

class UserContactBuilder
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserEmailVerified $event): void
    {
        //
        $user = $event->user;

        // search include also "soft-deleted" records
        $contact = UserContact::withTrashed()
            ->where('email', $user->email)
            ->first();

        if ($contact) {
            // Maybe
            if (Str::contains(', ', $user->name, true)) {
                [$lastName, $firstName] = explode(', ', $user->name);
            } else {
                $lastName = $user->name;
                $firstName = $user->name;
            }
            $contact->restore();
            $contact->update([
                'first_name'    => $firstName,
                'last_name'    => $lastName,
            ]);
        } else {
            // really new
            if (Str::contains(', ', $user->name, true)) {
                [$lastName, $firstName] = explode(', ', $user->name);
            } else {
                $lastName = $user->name;
                $firstName = $user->name;
            }
            UserContact::create([
                'user_id' => $user->id,
                'email'   => $user->email,
                'first_name'    => $firstName,
                'last_name'    => $lastName,
            ]);
        }
    }
}
