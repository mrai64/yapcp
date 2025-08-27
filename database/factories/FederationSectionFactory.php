<?php
/**
 * FederactionSection
 * child of Federation 
 */
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Federation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FederationSection>
 */
class FederationSectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'federation_id' => Federation::all('id')->random(5)->first()['id'],
            'code' => fake()->regexify('[A-Z]{3}'),
            'name' => fake()->text(),
            //
        ];
    }
}
