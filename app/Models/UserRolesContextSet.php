<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @mixin \Eloquent
 */
class UserRolesContextSet extends Model
{
    /** @use HasFactory<\Database\Factories\UserRolesContextSetFactory> */
    use HasFactory;
}
