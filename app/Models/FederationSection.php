<?php

/**
 * FederationSection contain the set of section n themes defined from
 * federations in own contest regulation docs. Every section is keyed
 * by a code and a set of rules.
 *
 * related to Federation
 * related to ContestSection
 *
 * 2025-08-28 renamed definition as excerptum (latin, means synopsis)
 * 2025-08-28 enlarged code 5 > 10
 * 2025-10-16 reformat
 * 2025-10-17 return id pk
 * 2025-10-21 relationship belongsTo
 * 2026-01-21 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


/**
 * @property int $id
 * @property string $federation_id
 * @property string $code
 * @property string $name_en official name in english
 * @property string $local_lang follow iso-3166 2 ascii lowercase
 * @property string $name_local in local name
 * @property string|null $synopsis synopsis from federal regulation docs
 * @property string $file_formats list of ext, comma separated
 * @property int $min_works greater zero == portfolio
 * @property int $max_works
 * @property int $short_size_max px
 * @property int $long_size_max px
 * @property int $file_size_max Bytes
 * @property int $monochromatic_required 0 == false, 1 == true
 * @property int $raw_required 0 == false, 1 == true
 * @property int $unique_prize 0 == false, 1 == true
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Federation $federation
 * @method static \Database\Factories\FederationSectionFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereFileFormats($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereLocalLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereLongSizeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereFileSizeMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereMaxWorks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereShortSideMax($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereMinWorks($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereMonochromaticRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereNameLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereUniquePrize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereRawRequired($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereSynopsis($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|FederationSection withoutTrashed()
 * @mixin \Eloquent
 */
class FederationSection extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'federation_sections';

    // default id unsigned bigint autoincrement

    protected $fillable = [
        'id', //                     pk
        'federation_id',//           fk federations.id
        'code', //                   uppercase
        'name_en', //                text unicode subset latin chars
        'local_lang', //             text
        'name_local', //             for use LTR RTL
        'synopsis', //               text
        'file_formats', //           list of file extension jpg, png, webp etc
        'min_works', //              unsigned int
        'max_works', //              unsigned int >= min_works
        'short_size_max', //         unsigned int pixel
        'long_size_max', //          unsigned int
        'file_size_max', //          unsigned int Bytes
        'monochromatic_required', // 1 true
        'raw_required', //           1 true
        'unique_prize', //           1 true
        // 'created_at',             reserved
        // 'updated_at',             reserved
        // deleted_at                reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'int', //                     standard bigint autoincrement
            'federation_id' => 'string',
            'code' => 'string',
            'name_en' => 'string',
            'local_lang' => 'string',
            'name_local' => 'string',
            'synopsis' => 'string',
            'file_formats' => 'string',
            'min_works' => 'int',
            'max_works' => 'int',
            'short_size_max' => 'int',
            'long_size_max' => 'int',
            'file_size_max' => 'int',
            'monochromatic_required' => 'int',
            'raw_required' => 'int',
            'unique_prize' => 'int',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONSHIP

    // federation_sections->federation
    // federation_sections.federation_id > federations.id
    public function federation(): BelongsTo
    {
        $federation = $this->belongsTo(
            related: Federation::class, //    ext class
            foreignKey: 'federation_id', //   int federation_sections.federation_id
            ownerKey: 'id' //                 ext federations.id
        );
        // log
        return $federation;
    }

    // federation_sections.code > contest_sections.code

}
