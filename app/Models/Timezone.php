<?php

/**
 * For auxiliary table timezones and
 * contain valid php timezone value instead of
 * it replace array timezones_list from model TimezonesList
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Timezone extends Model
{
    use HasFactory,SoftDeletes;

    public const table_name = 'timezones'; // real tablename should have a db prefix

    // pk not bigint unsigned incremental
    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    // fields list
    protected $fillable = [
        'id',
        'region_id',
        // created_at,
        // updated_at,
        // deleted_at,
    ];

    public function casts()
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' called');
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
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' called');
        $region = $this->hasOne(Region::class);

        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' region:' . json_encode($region) );
        return $region;
    }
}
