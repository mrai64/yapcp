<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FederationMore>
 */
class FederationMoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'referenced' => fake()->text(40),
            'federation_id' => fake()->regexify('[A-Z]{4}'),
            'field_name' => fake()->text(20),
            'field_label' => fake()->text(30),
            'field_validation_rules' => 'string|max:255',
            'field_default_value' => 'abcdefghijk',
            'field_default_value' => fake()->text(80),
        ];
    }
}
