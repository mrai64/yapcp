<?php
/**
 * Contest - main table
 * must be father of seven
 * use uuid 
 * related of Organization
 * 
 * 2025-09-17 In the photo contest organization some contest are grouped
 *            into so named circuit. A circuit have a contest record without
 *            section and jury. A circuit record 
 * 2025-10-22 Created an auxiliary table and add col vote_rule
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
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
        // circuit_id
        'federation_list',
        'url_1_rule',
        'url_2_concurrent_list',
        'url_3_admit_n_award_list',
        'url_4_catalogue',
        // timezone
        'day_1_opening',
        'day_2_closing',
        'day_3_jury_opening',
        'day_4_jury_closing',
        'day_5_revelations',
        'day_6_awards',
        'day_7_catalogues',
        'day_8_closing',
        'award_ceremony_info',
        'fee_info',
        'vote_rule',
        // created_at
        // updated_at
        // deleted_at
    ];

    // uuid as pk 
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
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
            'day_5_revelations'   => 'datetime',
            'day_6_awards'       => 'datetime',
            'day_7_catalogues'   => 'datetime',
            'day_8_closing'      => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    /**
     * GETTERs
     */
    public static function get_name_en(string $contest_id) : string
    {
        $inp_id = Str::of($contest_id);
        $get_contest = self::where('id', $inp_id)->get('name_en');
        Log::info( __FUNCTION__ . ' ' . __LINE__ . $get_contest);
        return (count($get_contest) == 0 ) ? '' : Str::of($get_contest[0]['name_en']);
    }

    
    /**
     * 
     */
    public function organization()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $organization = $this->hasOne(Organization::class);
        return $organization;
    }
    
    /**
     * 
     */
    public function sections()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $sections = $this->hasMany(ContestSection::class);
        return $sections;
    }

    /**
     * 
     */
    public function participants()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $participants = $this->hasMany(ContestParticipant::class);
        return $participants;
    }

    /**
     * 
     */
    public function country()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $country = $this->hasOne(Country::class, 'id', 'country_id');
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' country: ' . json_encode($country));
        return $country;
    }
}
