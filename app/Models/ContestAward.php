<?php
/**
 * Contest (section) Awards
 * - child of ContestSection (end not only)
 *   - child of Contest
 * 
 * uuid 
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
    // uuid as pk, don't need ++
    protected $keyType = 'string'; // char(36)
    public    $incrementing = false;

    // is_award
    public const valid_YN = [
        'Y',
        'N',
    ];
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
     * used in validation
     * 
     */
    public static function is_valid_is_award(ContestAward $award) : bool
    {
        return in_array( $award->is_award, self::valid_YN, true);
    }
    /**
     * GETTERS
     */
    // public static function get_award_list(string $contest_id)
}
