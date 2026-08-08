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
        $userContact = UserContact::inRandomOrder()->first() ?? UserContact::factory()->create();
        $photoBox = method_exists($user, 'photoBox') ? $user->photoBox() : 'photoBox';
        $userWorkId = Str::uuid7();
        $fileWidth   = fake()->numberBetween(800, 5000);
        $fileHeight  = fake()->numberBetween(800, 5000);

        return [
            'id' => $userWorkId, // image user work id
            'user_id' => $userContact->id,
            'title_en' => fake()->text(80),
            'title_local' => '',
            'file_path' => $photoBox . '/' . $userWorkId . '.jpg',
            'file_format'      => 'jpg',
            'file_size'        => fake()->numberBetween(200000, 9000000),
            'width'            => $fileWidth,
            'height'           => $fileHeight,
            'long_size'        => ($fileWidth >= $fileHeight) ? $fileWidth : $fileHeight,
            'short_size'       => ($fileWidth <= $fileHeight) ? $fileWidth : $fileHeight,
            'is_landscape'     => (bool)($fileWidth >= $fileHeight),
            'is_monochromatic' => false,
            'has_raw_file' => false,
        ];
    }
}
