<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'country_code' => fake()->regexify('[A-Z]{3}'), 
            'name' => fake()->text(),
            'email' => fake()->email(),
            'website' => fake()->url(), 
            //
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
