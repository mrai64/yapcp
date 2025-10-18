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
    protected $keyType = 'string'; // char(36)
    public    $incrementing = false;

    // under_patronage
    public const valid_under_patronages = [
        'Y',
        'N',
    ];

    protected $fillable = [
        // id section_id an uuid pk but
        'contest_id',//    real pk is combo of 
        'code', //         contest_id(uuid)+code(char(10))
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

    ]; 

    // pk is uuid
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

    protected function casts()
    {
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
        return (in_array( $section->under_patronage, self::valid_under_patronages, true));
    }

    // GETTER
    public function get_section_list( Contest $contest) : array
    {
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

    /**
     * 
     */
    public static function first_section_id(string $contest_id) : string
    {
        try {
            return self::whereNull('deleted_at')->where('contest_id', $contest_id)
                ->orderBy('id')->first('id')['id'];
        } catch (\Throwable $th) {
            Log::error(__FUNCTION__.' '.__LINE__ . 'in: contest_id:' . $contest_id . ' out: ' . $th->getMessage() );
            return '';
        }
    }

    /**
     * 
     */
    public function contest()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        // belongsTo( class_parent::class, class_parent.id, class_child.parent_id)
        $contest = $this->belongsTo(Contest::class); 
        return $contest;
    }
}
