<?php

/**
 * Organization | Organisation
 * They are Contest organizer
 *
 * uuid
 * hasFactory
 * softDelete
 * verifyEmail(?)
 *
 * 2025-08-30 rename country_code in country_id, fk countries.id
 * 2025-10-15 fix organization_name()
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Organization extends Model
{
    use HasFactory, SoftDeletes;

    // use env('DB_TABLE_PREFIX') .
    public const table_name = 'organizations';

    // id is uuid
    protected $keyType = 'string'; //     uuid string(36)

    public $incrementing = false; //   uuid don't need ++

    protected $fillable = [
        'country_id',
        'name',
        'email',
        'website',
        'contact',
    ];

    /**
     * uuid
     */
    public static function booted()
    {
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

    // GETTERS
    /**
     * Sorted by
     *   - country_id
     *   - name
     *   - created_at (to avoid dup, theoretically not but in real world)
     * & exclusion for deleted_at
     */
    public static function listed_by_country_id_name()
    {
        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' called');
        $organizations = DB::table('organizations')
            ->select('id', 'country_id', 'name', 'email', 'website')
            ->whereNull('deleted_at')
            ->orderBy('country_id', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found:'.json_encode($organizations));

        return $organizations;
    }

    public static function organization_name(string $organization_id): string
    {
        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in:'.$organization_id);
        $organization = self::where('id', $organization_id)->first();
        Log::info('Model '.__CLASS__.' '.__FUNCTION__.':'.__LINE__.' found:'.json_encode($organization));

        return $organization->name;
    }
}
