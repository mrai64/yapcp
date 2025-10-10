<?php
/**
 * UserRoles is child of Users
 * 
 * 2025-10-10 created an auxiliary table user_roles_role_set to manage
 *            previously value of valid_roles[]
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;
    //
    public const table_name = 'user_roles';

    // no factory and seeders, not now
    protected $fillable = [
        // 'id',
        'user_id', //         a uuid from users.id
        'role', //            in auxiliary table user_roles_role_sets
        'organization_id', // a uuid from organizations.id | NULL 
        'contest_id', //      a uuid from contests.id | NULL
        'federation_id', //   a uuid from federations.id | NULL
        'role_opening', //    datetime
        'role_closing', //    datetime >= role_opening
    ];

    protected function casts()
    {
        return [
            'role_opening' => 'datetime',
            'role_closing' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Complex validation, a field of 3 and only 1, not 0, not 2.
     * call it XOR
     * TODO build a UserRoleRule rule
     */
    public function only_one_role(UserRole $user_role) : bool 
    {
        // 2 is too much
        if (($user_role->organization_id) && ($user_role->contest_id)) {
            return false;
        }
        if (($user_role->organization_id) && ($user_role->federation_id)) {
            return false;
        }
        if (($user_role->contest_id) && ($user_role->federation_id)) {
            return false;
        }
        // 1 is right
        if (($user_role->organization_id) || ($user_role->contest_id) || ($user_role->federation_id)) {
            return true;
        }
        // 0 is too less
        return false;
    }
}
