<?php

/**
 * User Roles Role Set is a lookup table
 * for the field user_roles.role
 *
 * 2026-01-22 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class UserRolesRoleSet extends Model
{
    use SoftDeletes;

    public const TABLENAME = 'user_roles_role_sets';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //         pk bigint autoincrement
        'role', //       text
        // created_at    reserved
        // updated_at    reserved
        // deleted_at    reserved
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }


    // was: valid_roles
    public static function validRoles(): array
    {
        $validRoles = self::pluck('role')->toArray();
        // log
        $validRoles = asort($validRoles);
        // log
        return $validRoles;
    }
}
