<?php

/**
 * User Works
 * - uploaded by user in their photoBox folder
 * - for test purpose we need to pick a random file
 *   from an image folder (ia generated or picked
 *   from public et free repository) and put in
 *   photoBox folder
 */

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
        $user = UserContact::inRandomOrder()->first() ?? UserContact::factory()->create();
        $photoBox = method_exists($user, 'photoBox') ? $user->photoBox() : 'photoBox';
        $userWorkId = Str::uuid7();

        return [
            'id' => $userWorkId, // image user work id
            'user_id' => $user->id,
            'work_file' => $photoBox . '/' . $userWorkId . '.jpg',
            'extension' => 'jpg',
            // 'reference_year' => date('Y'),
            'title_en' => fake()->text(80),
            'title_local' => '',
            'long_side' => 1920,
            'short_side' => 1080,
            'monochromatic' => false,
            'raw' => false,
        ];
    }
}
