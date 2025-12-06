<?php

/**
 * FederationSection
 * child of Federation
 *
 * 2025-10-16 based on new table definition
 */

namespace Database\Factories;

use App\Models\Federation;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            // id
            'federation_id' => Federation::all('id')->random(5)->first()['id'],
            'code' => fake()->regexify('[A-Z]{6}'),
            'name_en' => fake()->text(),
            // local_lang
            // name_local
            // rule_definition
            // file formats
            // min_works
            // max_works
            // min_short_side
            // max_long_side
            // max_weight
            // monochromatic_required
            // raw_required
            // created_at
            // updated_at
            // deleted_at
        ];
    }
}
