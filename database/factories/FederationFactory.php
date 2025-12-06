<?php

/**
 * 2025-10-16 based on 2025_10_16_102443_create_feds_table
 */

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
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
        Log::info('Factory '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');

        return [
            'id' => fake()->regexify('[A-Z]{6}'), // check howto build random but from 3 to 6 chars
            'country_id' => DB::table(Country::table_name)->pluck('id')->random(5)->first(),
            'name_en' => fake()->text(),
            // local_lang
            // timezone_id
            'website' => fake()->url(),
            'contact_info' => fake()->address(),
            'created_at' => now(),
            'updated_at' => now(),
            // deleted_at
        ];
    }
}
