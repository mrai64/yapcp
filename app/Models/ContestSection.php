<?php

/**
 * Contest are made by theme and section
 * to apply, and should be valid for federation
 * distinctions management or not. Here we have
 * also some specific rules for section i.e.
 * min/max works (usually min 0 max 4, but for
 * reportage n portfolio should be min 4 max 12),
 * long n short side pixel size,
 * if requested monochromatic,
 * if RAW file should be requested etc.
 *
 * related to contests
 * related to contest_works
 * related to contest_awards
 *
 * no factory, no seeder
 *
 * 2025-10-26 add federation_section_id when under_patronage == Y
 * 2026-01-17 PSR-12 and relation functions and
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes; //  uuid booted()
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContestSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_sections';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    // table field list
    protected $fillable = [
        'id', //                     pk uuid
        'contest_id', //             fk contests.id
        'code', //                   unique( contest_id + code )
        'under_patronage', //        a Y/N instead boolean
        'federation_section_id', //  fk federation_sections.id
        'name_en',
        'name_local',
        'rule_format', //            list of extension file
        'rule_min', //               int # of works
        'rule_max', //               int
        'rule_min_size', //          int px size
        'rule_max_size', //
        'rule_max_weight', //        int MB
        'rule_monochromatic', //     a Y/N instead boolean
        'rule_raw_required', //      a Y/N instead boolean
        'rule_only_one', //          a Y/N instead boolean
        // created_at                reserved
        // updated_at                reserved
        // deleted_at                reserved
    ];

    // check Y/N fields
    private const VALID_YN = [
        'N', // 0 false
        'Y', // 1 true
    ];

    // pk is uuid
    public static function booted()
    {
        //dbg Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function casts()
    {
        // Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // Validators
    // was: is_a_valid_under_patronage
    public static function checkUnderPatronage(ContestSection $section): bool
    {
        return in_array(
            needle: $section->under_patronage,
            haystack: self::VALID_YN,
            strict: true
        );
    }

    public static function checkMonochromatic(ContestSection $section): bool
    {
        return in_array(
            needle: $section->rule_monochromatic,
            haystack: self::VALID_YN,
            strict: true
        );
    }

    public static function checkRawRequired(ContestSection $section): bool
    {
        return in_array(
            needle: $section->rule_raw_required,
            haystack: self::VALID_YN,
            strict: true
        );
    }

    public static function checkOnlyOne(ContestSection $section): bool
    {
        return in_array(
            needle: $section->rule_only_one,
            haystack: self::VALID_YN,
            strict: true
        );
    }

    // GETTER

    // was: get_section_list() - removed as unused function

    // was: first_section_id()
    public static function firstContestSectionId(string $contestId): string
    {
        try {
            $firstContestSectionId = self::where('contest_id', $contestId)
                ->orderBy('name_en')->first();

            return $firstContestSectionId->id ?? '';
        } catch (\Throwable $th) {
            Log::error(__FUNCTION__.' '.__LINE__.' in: contestId:'.$contestId.' out: '.$th->getMessage());

            return '';
        }
    }

    // RELATIONSHIP

    // contest_sections.contest_id > contests.id
    public function contest(): BelongsTo
    {
        $contest = $this->belongsTo(Contest::class);

        return $contest;
    }

    // contest_sections.id << contest_works.section_id
    public function works(): HasMany
    {
        $worksInSection = $this->hasMany(ContestWork::class, 'section_id', 'id');

        return $worksInSection;
    }

    // was: federation_section()
    // contest_sections.federation_section_id > federation_sections.id
    public function federationSection(): HasOne
    {
        $federationSection = $this->hasOne(
            related: FederationSection::class,
            foreignKey: 'id',
            localKey: 'federation_section_id'
        );

        return $federationSection;
    }
}
