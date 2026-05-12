<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserWork;
use App\Models\FederationMore;
use App\Models\UserWorkMore;
use Illuminate\Database\Seeder;

class UserWorkMoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pesca un utente esistente o ne crea uno tramite factory
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // 2. Pesca o crea un lavoro (UserWork) per questo specifico utente
        $userWork = UserWork::where('user_id', $user->id)->first()
                    ?? UserWork::factory()->create(['user_id' => $user->id]);

        // 3. Trova una definizione FederationMore che faccia riferimento alla tabella 'user_works'
        // Ad esempio quella per 'reference_year' definita nel FederationMoreSeeder
        $fedMore = FederationMore::where('referenced_table', 'user_works')->inRandomOrder()->first();

        if ($fedMore) {
            UserWorkMore::updateOrCreate([
                'user_work_id'  => $userWork->id,
                'federation_id' => $fedMore->federation_id,
                'field_name'    => $fedMore->field_name,
            ], [
                'field_value'   => $fedMore->field_default_value ?: '2025',
            ]);
        }
    }
}
