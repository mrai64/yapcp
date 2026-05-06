<?php

namespace Database\Seeders;

use App\Models\UserContactMore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserContactMoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        UserContactMore::factory()->create();
    }
}
