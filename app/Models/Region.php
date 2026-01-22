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
