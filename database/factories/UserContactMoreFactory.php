<?php

namespace Database\Factories;

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * @extends Factory<UserContactMore>
 */
class UserContactMoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attempts = 0;
        $maxAttempts = 10;

        do {
            // must be on a valid user_contact / user
            $userContact = DB::table(UserContact::TABLENAME)
                ->select('id')->whereNull('deleted_at')
                ->inRandomOrder()
                ->first();

            // must be on a valid federation
            $federationMore = DB::table(FederationMore::TABLENAME)
                ->select('*')->whereNull('deleted_at')
                ->inRandomOrder()
                ->first();

            // Verifica se la combinazione esiste già
            $exists = DB::table(UserContactMore::TABLENAME)
                ->where('user_id', $userContact->id)
                ->where('federation_id', $federationMore->federation_id)
                ->where('field_name', $federationMore->field_name)
                ->exists();

            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        // Se usciamo dal loop e il record esiste ancora, significa che abbiamo fallito i tentativi
        if ($exists) {
            throw new RuntimeException(sprintf(
                "Impossibile generare una combinazione univoca per %s dopo %d tentativi. Le combinazioni disponibili potrebbero essere esaurite.",
                UserContactMore::class, $maxAttempts
            ));
        }

        return [
            // id
            'user_id' => $userContact->id,
            'federation_id' => $federationMore->federation_id,
            'field_name' => $federationMore->field_name,
            'field_value' => $federationMore->field_default_value
        ];
    }
}
