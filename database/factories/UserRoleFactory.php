<?php

/**
 * make only a record at time
 */

namespace Database\Factories;

use App\Models\Contest;
use App\Models\Federation;
use App\Models\Organization;
use App\Models\User;
use App\Models\UserRolesRoleSet;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
        $userId = (string) Str::limit($user->id, 36);
        ds($user->id);
        $roleSet = UserRolesRoleSet::validRoles();
        $role = $roleSet[array_rand($roleSet)];
        $organization = '';
        $contest = '';
        $federation = '';
        // $which = rand(1, 3);
        $which = 3;
        switch ($which) {
            case 1:
                $organization = DB::table(Organization::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                $organization = $organization->id;
                break;

            case 2:
                $contest = DB::table(Contest::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                $contest = $contest->id;
                break;

            case 3:
            default:
                $federation = DB::table(Federation::TABLENAME)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                $federation = $federation->id;
                break;
        }
        ds('user:' . $user->id);
        ds('org: ' . $organization);
        ds('cont:' . $contest);
        ds('fed: ' . $federation);

        return [
            // id
            'user_id' => $user->id,
            'role' => $role,
            'organization_id' => $organization ?? '', //  uuid
            'contest_id' => $contest ?? '', //                     uuid
            'federation_id' => $federation ?? '', //               id
            'role_opening' => CarbonImmutable::now(),
            'role_closing' => CarbonImmutable::now()->addMonths(3),
        ];
    }
}
