<?php

/**
 * Key Values added to user_works
 * depending - reserved for a federation requirements
 * as in user_contacts_mores
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\UserWorkMoreFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore query()
 * @property int $id
 * @property string $user_work_id fk: user_works.id
 * @property string $federation_id fk: federation_mores.federation_id
 * @property string $field_name fk: federation_mores.field_name
 * @property string $field_value following rules when updated
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFieldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereUserWorkId($value)
 * @mixin \Eloquent
 */
class UserWorkMore extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkMoreFactory> */
    use HasFactory;
}
