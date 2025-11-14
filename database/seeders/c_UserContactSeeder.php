<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserContact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // UserContact::factory()->create();
        $user_list = User::all();
        foreach($user_list as $user){
            Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' SRC id:' . $user->id . ' name:'. $user->name );
            if (UserContact::where('user_id', $user->id)->count() > 0 ){
                Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' FND id:' . $user->id  );
                continue;
            }
            Log::info('Seeder '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' ADD id:' . $user->id  );
            UserContact::create([ 
                  'user_id'    => $user->id,
                  'first_name' => $user->name,
                  'last_name'  => $user->name,
                  'email'      => $user->email,
                  'country_id' => '',
                  'created_at' => $user->created_at,
                  'updated_at' => $user->updated_at,
                  'deleted_at' => $user->deleted_at,
                ]);
        }
    }
}
