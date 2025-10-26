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
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ContestWaiting extends Model
{
    use SoftDeletes,Notifiable;

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
        'email',
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

    // RELATIONSHIPs

    public function contest()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $contest = $this->hasOne(Contest::class, 'id',                 'contest_id');
        // . . . . . . . . . . . . . . . contests.id   contest_waitings.contest_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' contest:' . json_encode( $contest) );
        return $contest;
    }

    public function section()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $section = $this->hasOne(ContestSection::class, 'id',                 'section_id');
        // . . . . . . . . . . . . . . .contest:sections.id   contest_waitings.section_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' section:' . json_encode( $section) );
        return $section;
    }

    public function work()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $work = $this->hasOne(Work::class, 'id',                 'work_id');
        // . . . . . . . . . . . . . .works.id   contest_waitings.work_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' section:' . json_encode( $work) );
        return $work;
    }
    
    public function participant_user()
    {
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' called');
        $participant_user = $this->hasOne(UserContact::class, 'user_id',                 'participant_user_id');
        // . . . . . . . . . . . . . . . . . . . user_contacts.user_id   contest_waitings.participant_user_id
        Log::info('Model '. __CLASS__ .' '.__FUNCTION__.':'.__LINE__.' section:' . json_encode( $participant_user) );
        return $participant_user;
    }

}
