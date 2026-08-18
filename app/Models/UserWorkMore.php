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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

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
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Federation|null $federation
 * @property-read \App\Models\UserWork|null $userWork
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFieldName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereFieldValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore whereUserWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore withoutTrashed()
 * @mixin \Eloquent
 */
class UserWorkMore extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkMoreFactory> */
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_work_mores';

    protected $fillable = [
        'id',
        'user_work_id',
        'federation_id',
        'field_name',
        'field_value',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'integer',
            'user_work_id' => 'string',
            'federation_id' => 'string',
            'field_name' => 'string',
            'field_value' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    public function userWork(): BelongsTo
    {
        return $this->belongsTo(
            related: UserWork::class,
            foreignKey: 'user_work_id',
            ownerKey: 'id'
        );
    }

    public function federation(): BelongsTo
    {
        return $this->belongsTo(
            related: Federation::class,
            foreignKey: 'federation_id',
            ownerKey: 'id'
        );
    }
}
