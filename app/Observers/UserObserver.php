<?php

/**
 * User Observer
 * When User is created
 */

namespace App\Observers;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * $user already stored
     */
    public function created(User $user): void
    {
        Log::info("UserObserver: Metodo created attivato per l'utente " . $user->id);

        // build a UserContact record
        if (Str::contains(haystack: $user->name, needles: ', ', ignoreCase: false)) {
            [$lastName, $firstName] = explode(', ', $user->name);
        } else {
            $lastName = $user->name;
            $firstName = $user->name;
        }

        try {
            UserContact::create([
                'user_id' => $user->id, // Usiamo user_id (UUID) come da diario
                'last_name' => $lastName,
                'first_name' => $firstName,
                'country_id' => 'ITA', // as default
                'email' => $user->email,
            ]);
            Log::info("UserObserver: UserContact creato con successo per l'utente " . $user->id);
        } catch (\Throwable $th) {
            Log::error("UserObserver Error in created per utente {$user->id}: " . $th->getMessage());
        }
    }

    /**
     * Handle the User "updated" event.
     */
    public function updated(User $user): void
    {
        Log::info("UserObserver: Metodo updated attivato per l'utente " . $user->id);

        // update UserContact record
        if ($user->wasChanged('email')) {
            try {
                UserContact::withTrashed()
                    ->where('user_id', $user->id)
                    ->update(['email' => $user->email]);
                Log::info("UserObserver: Email aggiornata in UserContact per l'utente " . $user->id);
            } catch (\Throwable $th) {
                Log::error("UserObserver Error in updated per utente {$user->id}: " . $th->getMessage());
            }
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
