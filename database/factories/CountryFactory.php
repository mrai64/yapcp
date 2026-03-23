<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Country>
 */
class CountryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->regexify('[A-Z]{3}'),
            'country' => fake()->text(30),
            'lang_code' => fake()->regexify('[a-z]{2}_[A-Z]{2}'),
        ];
    }
}
