<?php

namespace Database\Factories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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
        $user = DB::table(User::table_name)
            ->select('id', 'email', 'name')->whereNull('deleted_at')->inRandomOrder()->first();
        $country = DB::table(Country::table_name)
            ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();

        return [
            // id            pk
            'user_id' => $user->id, //    fk users.id
            'country_id' => $country->id, // fk countries.id
            'first_name' => $user->name,
            'last_name' => '',
            'nick_name' => '',
            'email' => $user->email, // users.email
            'cellular' => '393301234567', //   use international code
            'passport_photo' => '', // \path\file.ext
            'address' => '',
            'address_line2' => '',
            'city' => '',
            'region' => '',
            'postal_code' => '',
            'website' => fake()->url(), // url
            'facebook' => fake()->url(), // url
            'x_twitter' => fake()->url(), // url
            'instagram' => fake()->url(), // url
            'whatsapp' => fake()->url(), // url
            // created_at
            // updated_at
            // deleted_at
        ];
    }
}
