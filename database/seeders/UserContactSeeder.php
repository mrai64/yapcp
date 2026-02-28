<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // UserContact::factory()->create();
        // fill missing user_contacts
        $userSet = User::all();
        foreach ($userSet as $user) {
            Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' SRC id:'.$user->id.' name:'.$user->name);
            if (UserContact::where('id', $user->id)->count() > 0) {
                Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' FND id:'.$user->id);

                continue;
            }
            $country = DB::table(Country::TABLENAME)->select('id')->inRandomOrder()->first();
            $countryId = ($country->id) ?? 'ITA';
            if (Str::contains($user->name, ',')) {
                [$lastName, $firstName] = explode(',', $user->name);
                $lastName = trim($lastName);
                $firstName = trim($firstName);
            } else {
                $firstName = $user->name;
                $lastName = $user->name;
            }
            Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ADD id:'.$user->id);
            UserContact::create([
                'user_id'       => $user->id,
                'first_name'    => $user->name,
                'last_name'     => $user->name,
                'email'         => $user->email,
                'country_id'    => $countryId,
                'cellular'      => fake()->e164PhoneNumber(),
                'created_at'    => $user->created_at,
                'updated_at'    => $user->updated_at,
                'deleted_at'    => $user->deleted_at,
            ]);
        }

    }
}
