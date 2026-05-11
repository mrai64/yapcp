<?php

namespace Database\Factories;

use App\Models\Contest;
use App\Models\ContestSection;
use App\Models\ContestWork;
use App\Models\UserContact;
use App\Models\UserWork;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContestWork>
 */
class ContestWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Recupera un concorso esistente o ne crea uno nuovo tramite la sua factory
        $contest = Contest::inRandomOrder()->first() ?? Contest::factory()->create();

        // Recupera una sezione del concorso scelto o ne crea una nuova
        $section = ContestSection::where('contest_id', $contest->id)->inRandomOrder()->first()
            ?? ContestSection::factory()->create(['contest_id' => $contest->id]);

        // Recupera un UserContact esistente (che contiene country_id e user_id) o lo crea
        $userContact = UserContact::inRandomOrder()->first() ?? UserContact::factory()->create();

        // Recupera un'opera (UserWork) dell'utente o ne crea una nuova associata ad esso
        $work = UserWork::where('user_id', $userContact->id)->inRandomOrder()->first()
            ?? UserWork::factory()->create(['user_id' => $userContact->id]);

        return [
            'contest_id'         => $contest->id,
            'section_id'         => $section->id,
            'user_id'            => $userContact->id,
            'user_work_id'       => $work->id,
            'country_id'         => $userContact->country_id,
            'portfolio_sequence' => fake()->numberBetween(1, 4),
            'is_admit'           => fake()->boolean(20),
        ];
    }
}
