<?php
/**
 * Contest - main table
 * must be father of seven
 * use uuid 
 * parent of Organization
 * 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Contest extends Model
{
    use HasFactory, SoftDeletes;
    public const table_name = 'contests';
    
    // uuid as pk 
    protected $keyType = 'string';//     uuid string(36)
    public    $incrementing = false;//   uuid don't need ++

    protected $fillable = [
        'id',
        'country_id',
        'name_en',
        'name_local',
        'lang_local',
        'organization_id',
        'contest_mark',
        'contact_info',
        'is_circuit',
        'federation_list',
        'url_1_rule',
        'url_2_concurrent_list',
        'url_3_admit_n_award_list',
        'url_4_catalogue',
        'day_1_opening',
        'day_2_closing',
        'day_3_jury_opening',
        'day_4_jury_closing',
        'day_5_revelation',
        'day_6_awards',
        'day_7_catalogues',
        'day_8_closing',
        'award_ceremony_info',
    ];

    // uuid as pk 
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

    /**
     * Casts()
     * 
     */
    protected function casts()
    {
        return [
            'day_1_opening'      => 'datetime',
            'day_2_closing'      => 'datetime',
            'day_3_jury_opening' => 'datetime',
            'day_4_jury_closing' => 'datetime',
            'day_5_revelation'   => 'datetime',
            'day_6_awards'       => 'datetime',
            'day_7_catalogues'   => 'datetime',
            'day_8_closing'      => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

}
