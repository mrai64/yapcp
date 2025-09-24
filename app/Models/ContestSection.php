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

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str; //  uuid booted()
use App\Models\Contest; //      father_table
use Illuminate\Support\Facades\Log;

class ContestSection extends Model
{
    use SoftDeletes;

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
        // id section_id
        'contest_id',
        'code',
        'under_patronage',
        'name_en',
        'name_local',
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
    /**
     * GETTER
     */
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
        return self::whereNull('deleted_at')->where('contest_id', $contest_id)
            ->orderBy('id')->first('id')['id'];
    }
}
