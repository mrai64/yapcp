<?php

namespace Database\Factories;

use App\Models\ContestCatalogPagesLayoutSet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContestCatalogPagesLayoutSet>
 */
class ContestCatalogPagesLayoutSetFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'layout_type' => fake()->text(16),
            'template_file_path' => fake()->text(),
            'title_en' => fake()->text(),
        ];
    }
}
