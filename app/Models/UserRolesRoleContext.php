<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $role fk user_roles_role_sets.id
 * @property string $context fk user_roles_context_set.id
 * @property int $green true green flag, false red flag
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\UserRolesRoleContextFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereContext($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereGreen($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesRoleContext withoutTrashed()
 * @mixin \Eloquent
 */
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
