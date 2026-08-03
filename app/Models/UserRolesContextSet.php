<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static \Database\Factories\UserRolesContextSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet query()
 * @property int $id
 * @property string $context_type the real pk
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet whereContextType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRolesContextSet withoutTrashed()
 * @mixin \Eloquent
 */
class UserRolesContextSet extends Model
{
    /** @use HasFactory<\Database\Factories\UserRolesContextSetFactory> */
    use HasFactory;
    use SoftDeletes;
    //
    public const TABLENAME = 'user_roles_context_sets';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', // pk bigint unsigned autoincrement
        'context_type', // the real pk
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];

    protected function casts(): array
    {
        return [
            'id' => 'int',
            'context_type' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONS

}
