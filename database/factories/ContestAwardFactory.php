<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestAward;
use App\Models\ContestSection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContestAward>
 */
class ContestAwardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        /** @var Contest $contest */
        $contest = Contest::inRandomOrder()->first() ?? Contest::factory()->create();
        /** @var ContestSection $section */
        $section = $contest->contestSections()->inRandomOrder()->first()
            ?? ContestSection::factory()->create(['contest_id' => $contest->id]);

        return [
            'contest_id'     => $contest->id,
            'section_id'     => $section->id,
            'section_code'   => $section->code,
            'award_code'     => fake()->unique()->bothify('??-###'),
            'award_name'     => fake()->words(2, true) . ' Award',
            'is_award'       => fake()->boolean(80),
            'winner_work_id' => null,
            'winner_user_id' => null,
            'winner_name'    => null,
        ];
    }
}
