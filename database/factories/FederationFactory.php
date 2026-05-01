<?php

/**
 * 2025-10-16 based on 2025_10_16_102443_create_feds_table
 */

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Log;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Federation>
 */
class FederationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        Log::info('Factory ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');

        return [
            'id' => fake()->unique()->regexify('[A-Z]{6}'), // check howto build random but from 3 to 6 chars
            'country_id' => Country::factory(),
            'name_en' => fake()->text(),
            'local_lang' => fake()->regexify('[a-z]{2}_[A-Z]{2}'),
            'timezone_id' => function () {
                return \App\Models\Timezone::inRandomOrder()->first()?->id
                    ?? \App\Models\Timezone::factory()->create()->id;
            },
            'website' => fake()->url(),
            'contact_info' => fake()->address(),
            // 'created_at' => now(),
            // 'updated_at' => now(),
            // deleted_at
        ];
    }
}
