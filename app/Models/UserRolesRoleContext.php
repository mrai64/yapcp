<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRolesRoleContext extends Model
{
    /** @use HasFactory<\Database\Factories\UserRolesRoleContextFactory> */
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_roles_role_contexts';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //         pk bigint autoincrement
        'role', //       string
        'context', //    string
        'green', //      boolean
        // created_at    reserved
        // updated_at    reserved
        // deleted_at    reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'int',
            'role' => 'string',
            'context' => 'string',
            'green' => 'int',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    // RELATIONS


}
