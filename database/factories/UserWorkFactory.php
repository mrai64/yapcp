<?php

namespace Database\Factories;

use App\Models\UserContact;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserWork>
 */
class UserWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = UserContact::all()->random(7)->first();
        $photoBox = $user->photoBox();
        $photoId = Str::uuid7();

        return [
            'id' => $photoId, // image user work id
            'user_id' => $user->user_id,
            'work_file' => $photoBox . '/' . $photoId . '.jpg',
            'extension' => 'jpg',
            'reference_year' => date('Y'),
            'title_en' => fake()->text(80),
            'title_local' => '',
            'long_side' => 1920,
            'short_side' => 1080,
            'monochromatic' => false,
        ];
    }
}
