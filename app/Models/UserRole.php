<?php
/**
 * UserRoles is child of Users
 * 
 * 2025-10-10 created an auxiliary table user_role_role_set to manage
 *            previously value of valid_roles[]
 * 2025-10-18 user_roles had a 1:1: relationship w/user_role_role_sets 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class UserRole extends Model
{
    use HasFactory, SoftDeletes;
    //
    public const table_name = 'user_roles';

    // no factory and seeders, not now
    protected $fillable = [
        // 'id',
        'user_id', //         a uuid from users.id
        'role', //            in auxiliary table user_role_role_sets
        'organization_id', // a uuid from organizations.id | NULL 
        'contest_id', //      a uuid from contests.id | NULL
        'federation_id', //   a uuid from federations.id | NULL
        'role_opening', //    datetime
        'role_closing', //    datetime >= role_opening
    ];

    protected function casts()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
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
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        // 
        return ( ($user_role->organization_id) Xor ( ($user_role->contest_id) Xor ($user_role->federation_id) ) );
    }

    public static function valid_roles()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $valid = UserRolesRoleSet::valid_roles();
        return $valid;
    }
}
