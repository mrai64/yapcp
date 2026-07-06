<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @method static \Database\Factories\TimezonesRegionSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezonesRegionSet withoutTrashed()
 * @mixin \Eloquent
 */
class TimezonesRegionSet extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'timezones_region_sets';

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
}
