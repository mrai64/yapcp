<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        return [
            'code' => fake()->regexify('[A-Z]{6}'), // check howto build random but from 3 to 6 chars
            'name' => fake()->text(),
            'website' => fake()->url(),
            // 'country_id' => fake()->location()->countryCode('alpha-3'),
            // 'country_id' => Country::all('id')->random()->first()['id'],
            'country_id' => DB::table(Country::table_name)->pluck('id')->random(5)->first(),
            'contact' => fake()->address(),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
