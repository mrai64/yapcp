<?php

/**
 * Action required from Organization Contest Design,
 * when an <added juror in Contest> become a new platform registered user
 *
 * Note: the juror as first act need to ask a change password, then
 *   as second change/adjust personal contact data
 *
 */

namespace App\Actions\Yapcp;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class RegisterContestJuror // don't extend
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            $actionName = class_basename($this);
            Log::info('Action: ' . $actionName . 'requested');
            // Disabilita gli observer solo per questa operazione
            User::flushEventListeners();
            UserContact::flushEventListeners();
            Log::info('Action: ' . $actionName . ' observer off');
            // 1. Creazione Utente
            $user = User::create([
                'email' => $data['email'],
                'name'  => $data['last_name'] . ', ' . $data['first_name'],
                'password' => Hash::make(Str::random(16)),
            ]);
            Log::info('Action: ' . $actionName . ' user added');

            // 2. Creazione Contatto (stesso ID)
            $contact = UserContact::create([
                'id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'country_id' => $data['country_id'],
            ]);
            Log::info('Action: ' . $actionName . ' user_contacts added');

            // 3. Creazione forzata cartella (evita dipendenza da Observer)
            $photoBox = $contact->photoBox();
            Storage::disk('public')->makeDirectory('/photos/' . $photoBox);
            Log::info('Action: ' . $actionName . ' photoBox added');

            return $user;
        });
    }
}
