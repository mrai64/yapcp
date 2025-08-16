<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
          //'iso3' => fake()->text(3)->upper(), minimo 5
            'iso3' => fake()->regexify('[A-Z]{3}'),
            'country' => fake()->text(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
