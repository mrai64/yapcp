<?php

namespace Database\Factories;

use App\Models\TimezoneRegionSet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timezone>
 */
class TimezoneFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->unique()->timezone(),
            'region_id' => TimezoneRegionSet::factory(),
        ];
    }
}
