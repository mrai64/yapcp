<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Support\Str;

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
            //'code' => Str::limit( fake()->regexify('[A-Z]{6}'), rand(3,6) ),
            'name' => fake()->text(),
            'website' => fake()->url(),

            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
