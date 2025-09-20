<?php
/**
 * UserRoles is child of Users
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
    public const array valid_roles = [
        'chairman of',
        'member of',
        'president of',
        'secretary of',
    ];

    // no factory and seeders, not now
    protected $fillable = [
        // 'id',
        'user_id', // a uuid from users.id
        'role', // one of valid_roles[]
        'organization_id', // a uuid from organizations.id | NULL 
        'contest_id', // a uuid from contests.id | NULL
        'federation_id', // a uuid from federations.id | NULL
        'role_opening', // datetime
        'role_closing', // datetime >= role_opening
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
    /**
     * validation like enum
     */
    public function is_a_valid_role(UserRole $user_role) : bool {
        return (in_array( $user_role->role, self::valid_roles, true));
    }
}
