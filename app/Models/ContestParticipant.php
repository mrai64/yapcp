<?php
/**
 * Contest (user n works ) Participant
 * - the table with most fk 
 * - one payload field only: is_admit
 * 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log; // Log::info
use Illuminate\Support\Str; //         pk uuid 

class ContestParticipant extends Model
{
    //
    use HasFactory, SoftDeletes;

    public const table_name = 'contest_participants';

    // pk uuid
    protected $keyType      = 'string';
    public    $incrementing = false;

    // is_admit
    public const valid_YN = [
        'Y',
        'N',
    ];

    // field list fillable in factory
    protected $fillable = [
        // id - uuid assigned
        'contest_id', // uuid fk
        'section_id', // uuid fk
        'country_id', // char(3)
        'user_id', //    uuid fk
        'work_id', //    uuid fk
        'is_admit', //   Y/N
        // created_at
        // updated_at
        // deleted_at
    ];

    // pk uuid
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
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

    // public function get_participant_list_by_contest_id()
    // public function get_contest_id_list_by_user_id()
    public static function get_participant_by_section_n_user(string $section_id, string $user_id) : string
    {
        $count = self::where('user_id', $user_id)->where('section_id', $section_id)->count();
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.$count);
        return $count;
    }
    public static function get_participant_by_work(string $contest_id, string $work_id) : string
    {
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' in: 1:'.$contest_id. ' 2:'. $work_id);
        $participant = self::where('contest_id', $contest_id)->where('work_id', $work_id)->get('id');
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.$participant);
        $participant_id = (count($participant)) ? $participant[0]['id'] : '';
        Log::info(__CLASS__.' '.__FUNCTION__.':'.__LINE__.' out:'.$participant_id);
        return $participant_id;
    }
}
