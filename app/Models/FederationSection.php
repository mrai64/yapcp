<?php
/**
 * FederationSection
 * child of Federation
 * 2025-08-28 renamed definition as excerptum (latin, means synopsis)
 * 2025-08-28 enlarged code 5 > 10
 * 2025-10-16 reformat
 * 2025-10-17 return id pk
 * 2025-10-21 relationship belongsTo
 *
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class FederationSection extends Model
{
    use HasFactory, SoftDeletes;

    public const table_name = 'federation_sections';

    protected $fillable = [
        // id
        'federation_id',
        'code',
        'name_en',
        'local_lang',
        'name_local',
        'rule_definition',
        'file_formats',
        'min_works',
        'max_works',
        'min_short_side',
        'max_long_side',
        'monochromatic_required', // 1 true
        'raw_required', //           1 true
        'created_at',
        'updated_at',
        // deleted_at
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
    public function federation()
    {
        Log::info('Models '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $federation = $this->belongsTo(Federation::class);
        // . . . . . . . . . . . . . . . . . . .federations.id  federation_sections.federation_id
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' federation:' . json_encode($federation) );

        return $federation;
    }
}
