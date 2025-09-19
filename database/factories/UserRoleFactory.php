<?php
/**
 * make only a record at time
 */
namespace Database\Factories;

use App\Models\Contest;
use App\Models\Federation;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\select;

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
        $user = DB::table( User::table_name )
            ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
        $role = array_rand(UserRole::valid_roles);
        $organization_id = '';
        $contest_id = '';
        $federation_id = '';
        $which = rand(1, 3);
        switch ($which) {
            case '1':
                $organization_id = DB::table( Organization::table_name)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;

            case '2':
                $contest_id = DB::table( Contest::table_name)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;

            default:
                $federation_id = DB::table( Federation::table_name)
                    ->select('id')->whereNull('deleted_at')->inRandomOrder()->first();
                break;
        }

        return [
            // id
            'user_id'         => $user->id,
            'role'            => UserRole::valid_roles[$role],
            'organization_id' => ($organization_id === '') ? NULL : $organization_id->id,
            'contest_id'      => ($contest_id === ''     ) ? NULL : $contest_id->id,
            'federation_id'   => ($federation_id === ''  ) ? NULL : $federation_id->id,
            // 'role_opening'
            // 'role_closing'
        ];
    }
}
