<?php

/**
 * make only a record at time
 */

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserRole>
 */
class UserRoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = DB::table(User::TABLENAME)
            ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
        $role = array_rand(UserRole::validRoles);
        $organization_id = '';
        $contest_id = '';
        $federation_id = '';
        $which = rand(1, 3);
        switch ($which) {
            case '1':
                $organization_id = DB::table(Organization::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;

            case '2':
                $contest_id = DB::table(Contest::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;

            default:
                $federation_id = DB::table(Federation::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;
        }

        return [
            // id
            'user_id' => $user->id,
            'role' => UserRole::validRoles[$role],
            'organization_id' => ($organization_id === '') ? null : $organization_id->id, // uuid
            'contest_id' => ($contest_id === '') ? null : $contest_id->id, //     uuid
            'federation_id' => ($federation_id === '') ? null : $federation_id->id, //  id
            // 'role_opening'
            // 'role_closing'
        ];
    }
}
