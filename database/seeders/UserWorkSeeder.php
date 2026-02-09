<?php

namespace Database\Seeders;

use App\Models\UserWork;
use Illuminate\Database\Seeder;

class UserWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        UserWork::factory()->create();
    }
}
