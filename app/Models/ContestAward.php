<?php

/**
 * Contest Definition (section) Awards
 * - child of ContestSection (end not only)
 *   - child of Contest
 *
 * uuid pk
 * is_award mean that some prize are A prize, i.e. valid for some federations distinctions, others are "simple" prize.
 *
 * 2025-12-05 Log
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // uuid booted()

class ContestAward extends Model
{
    use SoftDeletes;

    public const table_name = 'contest_awards';

    // protected $primaryKey = 'id' default
    protected $keyType = 'string'; // uuid

    public $incrementing = false;

    // field list
    protected $fillable = [
        // id - uuid
        'contest_id',
        'section_id',
        'section_code',
        'award_code',
        'award_name',
        'is_award',
        'winner_work_id',
        'winner_user_id',
        'winner_name',
        // created_at
        // updated_at
        // deleted_at
    ];

    // is_award as enum set
    // TODO change in true/false
    public const valid_YN = [
        'Y',
        'N',
    ];

    // pk is uuid
    public static function booted()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

    protected function casts()
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // VALIDATORS

    public static function is_valid_is_award(ContestAward $award): bool
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');

        return in_array($award->is_award, self::valid_YN, true);
    }

    // GETTERS

    // RELATIONS

}
