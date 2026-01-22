<?php

/**
 * FederationSection containd the set of section n themes defined from
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
        'name_en', //                text
        'local_lang', //             text
        'name_local', //             for use LTR RTL
        'rule_definition', //        text
        'file_formats', //           list of file extension jpg, png, webp etc
        'min_works', //              unsigned int
        'max_works', //              unsigned int >= min_works
        'min_short_side', //         unsigned int pixel
        'max_long_side', //          unsigned int >= min_short_side
        'monochromatic_required', // 1 true
        'raw_required', //           1 true
        // 'created_at',             reserved
        // 'updated_at',             reserved
        // deleted_at                reserved
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // RELATIONSHIP

    // federation_sections->federation
    // federation_sections.federation_id > federations.id
    public function federation()
    {
        $federation = $this->belongsTo(Federation::class);
        // log
        return $federation;
    }

    // federation_sections.code > contest_sections.code

}
