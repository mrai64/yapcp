<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestJury;
use App\Models\ContestSection;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContestJury>
 */
class ContestJuryFactory extends Factory
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
        /** @var User $user */
        $jurorUser = User::factory()->create();

        return [
            'contest_id'     => $contest->id,
            'section_id'     => $section->id,
            'user_id'        => $jurorUser->id,
            'is_president'   => fake()->boolean(80),
            'qualify'        => 'President of ' . fake()->words(2, true) . ' Club',
        ];
    }
}
