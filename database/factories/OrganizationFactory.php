<?php

/**
 * 2025-08-30 rename country_code in country_id
 *            country_id is fk countries.id
 */

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // uuid
            'country_id' => DB::table(Country::TABLENAME)->pluck('id')->random(5)->first(),
            'name' => fake()->text(),
            'email' => fake()->email(),
            'website' => fake()->url(),
            //
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
