<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserWorkValidationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}

/**
 *
 *
// 1. Validazione per sezione indipendente (section_id popolato, federation_section_id null)
UserWorkValidation::factory()->create();

// 2. Validazione per sezione con patrocinio federale
UserWorkValidation::factory()
    ->forFederationSection()
    ->create();

// 3. Passando istanze o ID esistenti
UserWorkValidation::factory()->create([
    'user_work_id'          => $userWork->id,
    'section_id'            => $contestSection->id,
    'federation_section_id' => $contestSection->federation_section_id, // può essere null o int
    'validator_user_id'     => $validator->id,
]);
 *
 */
