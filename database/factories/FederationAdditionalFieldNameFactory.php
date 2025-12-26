<?php

namespace Database\Factories;

use App\Models\Federation;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class FederationAdditionalFieldNameFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // id auto
            'federation_id' => Federation::all('id')->random(7)->first()['id'], // TODO link to Federation
            'federation_field_name' => fake()->word(),
            'federation_field_label' => fake()->sentence(3),
            'federation_field_validation_rules' => 'string|max:255', // example
            // created_at
            // updated_at
            // deleted_at
        ];
    }
}
