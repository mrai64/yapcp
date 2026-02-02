<?php

/**
 * Lookup table for timezone regions
 *
 * related to Timezone
 *
 * TODO remove table as php has own function
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property string $id aux
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Timezone> $timezones
 * @property-read int|null $timezones_count
 * @method static \Database\Factories\RegionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Region withoutTrashed()
 * @mixin \Eloquent
 */
class Region extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'regions';

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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // getters

    // RELATIONSHIP

    /**
     * return Timezone timezones.region_id N:1 regions.id
     */
    public function timezones()
    {
        $timezones = $this->hasMany(Timezone::class);
        // log
        return $timezones;
    }
}
