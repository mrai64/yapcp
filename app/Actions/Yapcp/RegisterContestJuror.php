<?php 

/**
 * Action required bu Organization Contest Design
 * when an added juror in Contest become a platform registered user
 * 
 */

namespace App\Actions\Yapcp;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RegisterContestJuror
{
    public function execute(array $data): User
    {
        return DB::transaction(function () use ($data) {
            // Disabilita gli observer solo per questa operazione
            User::flushEventListeners();
            UserContact::flushEventListeners();
            // 1. Creazione Utente
            $user = User::create([
                'email' => $data['email'],
                'name'  => $data['last_name'] . ', ' . $data['first_name'],
                'password' => Hash::make($data['email']),
            ]);

            // 2. Creazione Contatto (stesso ID)
            $contact = UserContact::create([
                'id' => $user->id,
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'country_id' => $data['country_id'],
            ]);

            // 3. Creazione forzata cartella (evita dipendenza da Observer)
            $photoBox = $contact->photoBox();
            Storage::disk('public')->makeDirectory('/photos/' . $photoBox);

            return $user;
        });
    }
}
