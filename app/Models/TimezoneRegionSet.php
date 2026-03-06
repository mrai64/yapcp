<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Timezone> $timezones
 * @property-read int|null $timezones_count
 * @method static \Database\Factories\TimezoneRegionSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimezoneRegionSet withoutTrashed()
 * @mixin \Eloquent
 */
class TimezoneRegionSet extends Model
{
    /** @use HasFactory<\Database\Factories\TimezoneRegionSetFactory> */
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'timezone_region_sets';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // char(10) uppercase
    public $incrementing = false; //  with no increment

    // field list
    protected $fillable = [
        'id', //         pk
        // created_at,   reserved
        // updated_at,   reserved
        // deleted_at,   reserved
    ];

    public function casts()
    {
        return [
            'id' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONS
    public function timezones(): HasMany
    {
        $timezones = $this->hasMany(
            related: Timezone::class, // ext class
            foreignKey: 'region_id', //  ext timezones.region_id
            localKey: 'id' //            int timezone_region_sets.id
        );
        // log
        return $timezones;
    }


}
