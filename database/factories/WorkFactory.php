<?php

/**
 * Work should be considered
 * child of UserContact
 *
 * works.id is uuid()
 */

namespace Database\Factories;

use App\Models\UserContact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user_contact = UserContact::all()->random(5)->first();
        $photo_box = $user_contact->photoBox();

        return [
            'id' => Str::uuid(),
            'user_id' => $user_contact->user_id,
            'work_file' => fake()->imageUrl(1920, 1080, null, false, null, false, 'jpg'), // TODO correct it
            'extension' => 'jpg',
            'reference_year' => date('Y'),
            'title_en' => fake()->text(120),
            'title_local' => '',
            'long_side' => 1920,
            'short_side' => 1080,
            'monochromatic' => 'N',
        ];
    }
}
