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
