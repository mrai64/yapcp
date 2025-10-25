<?php
/**
 * Contest Waiting
 * Works Parked away from contest
 * wait a moment: that work had a problem 
 * 
 * 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContestWaiting extends Model
{
    use SoftDeletes;

    // protected $primaryKey= 'id';
    protected $keyType      = 'string';
    public    $incrementing = false;

    protected $fillable = [
        // id
        'contest_id', //           uuid fk
        'section_id', //           uuid fk
        'participant_user_id', //  uuid fk
        'work_id', //              uuid fk
        'portfolio_sequence', //   0..255
        'because', //              text
        'organization_user_id', // uuid fk
        // created_at
        // updated_at
        // deleted_at
    ];

    // pk uuid
    public static function booted() 
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
        });
    }
    
    protected function casts()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONSHIP

}
