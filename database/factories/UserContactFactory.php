<?php

/**
 * When User is for platform access
 * UserContact is for all other data used to
 * manage contest participation, as participant,
 * as juror, as contest organizer and also as federation
 * members. Data required from a specific federation
 * are stored in userMore.
 *
 */

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserContact>
 */
class UserContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // need a valid users.id
        $user = DB::table(User::TABLENAME)->select('id', 'email', 'name')->inRandomOrder()->first();
        if (Str::contains($user->name, ',')) {
            [$lastName, $firstName] = explode(',', $user->name);
            $lastName = trim($lastName);
            $firstName = trim($firstName);
        } else {
            $firstName = $user->name;
            $lastName = $user->name;
        }

        return [
            'id' => $user->id,
            'user_id' => $user->id,
            'country_id' => Country::factory(),
            'first_name' => $firstName,
            'last_name' => $lastName,
            'nick_name' => '',
            'email' => $user->email, //       users.email
            'cellular' => fake()->e164PhoneNumber(), //  e164 international cellular code
            'passport_photo' => '', //                   \path\file.ext
            'address' => '', //                          postal address
            'address_line2' => '',
            'city' => '',
            'region' => '',
            'postal_code' => '',
            'website' => fake()->url(), //               url
            'facebook' => fake()->url(), //              url
            'x_twitter' => fake()->url(), //             url
            'instagram' => fake()->url(), //             url
            'whatsapp' => fake()->url(), //              url
            // created_at
            // updated_at
            // deleted_at
        ];
    }
}
