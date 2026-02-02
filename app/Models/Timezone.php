<?php

/**
 * Timezone is alternative to php function
 *
 * related to Contest
 * related to UserContact
 * related to Federation
 *
 * 2026-01-21 PSR12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property string $id valid for php_timezones
 * @property string $region_id fk regions.id
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read int|null $contests_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Federation> $federations
 * @property-read int|null $federations_count
 * @property-read \App\Models\Region|null $region
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContact> $userContacts
 * @property-read int|null $user_contacts_count
 * @method static \Database\Factories\TimezoneFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereRegionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Timezone withoutTrashed()
 * @mixin \Eloquent
 */
class Timezone extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'timezones'; // real tablename should have a db prefix

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // char(40)
    public $incrementing = false; //  with no increment

    // fields list
    protected $fillable = [
        'id', //           pk
        'region_id', //    fk regions.id
        // created_at,     reserved
        // updated_at,     reserved
        // deleted_at,     reserved
    ];

    public function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONSHIP

    public function region()
    {
        $region = $this->hasOne(Region::class);
        // log
        return $region;
    }

    // timezones.id > contests.timezones.id
    public function contests()
    {
        $contests = $this->hasMany(
            related: Contest::class,
            foreignKey: 'timezone_id',
            localKey: 'id'
        );
        // log
        return $contests;
    }


    public function federations()
    {
        $fed = $this->hasMany(
            related: Federation::class,
            foreignKey: 'timezone_id',
            localKey: 'id'
        );
        // log
        return $fed;
    }

    public function userContacts()
    {
        $fed = $this->hasMany(
            related: UserContact::class,
            foreignKey: 'timezone_id',
            localKey: 'id'
        );
        // log
        return $fed;
    }



}
