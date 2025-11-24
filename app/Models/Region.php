<?php
/**
 * auxiliary table for timezones
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Region extends Model
{
    use HasFactory,SoftDeletes;
    public const table_name = 'regions';
    // pk not bigint unsigned incremental
    // protected $primaryKey = 'id';
    protected $keyType = 'string'; 
    public $incrementing = false;

    // field list
    protected $fillable = [
        'id',
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
    
    // getters 
    
    // RELATIONSHIP

    /**
     * return Timezone timezones.region_id N:1 regions.id
     */
    public function timezones()
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' called');
        $timezones = $this->hasMany(Timezone::class);
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__.' timezones:' . json_encode($timezones) );
        return $timezones;
    }
}
