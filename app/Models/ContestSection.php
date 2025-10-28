<?php
/**
 * Contest Sections is a child table for Contest
 * pk uuid
 * fk contests.id uuid
 * under_patronage is a enum-like and boolean-like
 * value: Y, otherwise: N.
 * code: free code, but when under_patronage == 'Y'
 * a check for federation_section_list should be done
 * and require a FederationSection access
 *
 * no factory, no seeder
 * 
 * 2025-10-26 add federation_section_id when under_patronage == Y
 *
 */
namespace App\Models;

use App\Models\Contest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str; //  uuid booted()
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Log;

class ContestSection extends Model
{
    use HasFactory,SoftDeletes;

    public const table_name = 'contest_sections';

    // pk is uuid, and don'need ++
    protected $primaryKey = 'id';
    protected $keyType = 'string'; // char(36)
    public    $incrementing = false;

    // under_patronage
    public const valid_under_patronages = [
        'Y',
        'N',
    ];

    protected $fillable = [
        // id              uuid
        'contest_id',//    
        'code', //         unique( contest_id + code )
        'under_patronage', // set Y/N or boolean or ?
        'name_en',
        'name_local',
        // rule_format - they have default values
        // rule_min
        // rule_max
        // rule_min_size
        // rule_max_size
        // rule_max_weight
        // rule_monochromatic
        // TODO rule_raw
        // created_at
        // updated_at
        // deleted_at

    ];

    // pk is uuid
    public static function booted() {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

    protected function casts()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }
    /**
     * IS_A_Valid_field
     *
     * Check $section->under_patronage enum like
     */
    public function is_a_valid_under_patronage(ContestSection $section) : bool
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return (in_array( $section->under_patronage, self::valid_under_patronages, true));
    }

    // GETTER

    public function get_section_list( Contest $contest) : array
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $section_list = self::whereNull('deleted_at')->where('contest_id', $contest->id)
            ->order_by('code')->orderBy('name_en')
            ->get(['id', 'code', 'name_en', 'name_local', 'under_patronage']);
        $section_array = [];
        foreach ($section_list as $section) {
            $section_array[] = [
                'id'              => $section->id,
                // contest_id
                'code'            => $section->code,
                'under_patronage' => $section->under_patronage,
                'name_en'         => $section->name_en,
                'name_local'      => $section->name_local,
                // created_at,
                // updated_at,
                // deleted_at,
            ];
        }
        return $section_array;
    }

    public static function first_section_id(string $contest_id) : string
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        try {
            return self::whereNull('deleted_at')->where('contest_id', $contest_id)
                ->orderBy('id')->first('id')['id'];
        } catch (\Throwable $th) {
            Log::error(__FUNCTION__.' '.__LINE__ . 'in: contest_id:' . $contest_id . ' out: ' . $th->getMessage() );
            return '';
        }
    }

    // RELATIONSHIPs

    public function contest()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        // belongsTo( class_parent::class, class_parent.id, class_child.parent_id)
        $contest = $this->belongsTo(Contest::class);
        // . . . . . . . contests.id contest_sections.id
        return $contest;
    }

    public function works()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $works = $this->hasMany(ContestWork::class, 'section_id',                 'id');
        //. . . . . . . . . . . . . . .contest_works.section_id   contest_sections.id
        return $works;
    }

    public function federation_section()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $federation_section = $this->hasOne(FederationSection::class);
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' federation_section:' . json_encode($federation_section) );
        return $federation_section;
    }
}
