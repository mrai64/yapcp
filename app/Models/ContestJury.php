<?php

/**
 * Contest (Section) Jury is
 * child of ContestSection
 *
 * id as uuid
 *
 * 2025-10-28 add is_juror
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // uuid booted()

class ContestJury extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_juries';

    // uuid as pk, don't need ++
    protected $keyType = 'string'; // char(36)

    public $incrementing = false;

    protected $fillable = [
        // id                 contest_juries.id NOT juror user_id
        'section_id',
        'user_contact_id', // user_contacts.user_id juror
        'is_president',
        // created_at
        // updated_at
        // deleted_at
    ];

    // is_president
    public const valid_YN = [
        'Y',
        'N',
    ];

    // pk is uuid
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

    /**
     * used in validation
     */
    public static function is_valid_is_president(ContestJury $juror): bool
    {
        return in_array($juror->is_president, self::valid_YN, true);
    }

    /**
     * getter
     * juror list of section
     * section list for juror
     */
    public static function juror_list_for_section(string $section_id): array
    {
        $jury_list = [];
        $the_jury = self::whereNull('deleted_at')->where('section_id', $section_id)->get(['id', 'user_contact_id']);
        foreach ($the_jury as $juror) {
            $jury_list[] = $juror->user_contact_id;
        }

        return $jury_list;
    }

    /**
     * count of
     */
    public static function count_juror(string $section_id): int
    {
        Log::info(__FUNCTION__.' '.__LINE__.'  in: '.$section_id);
        $result = self::whereNull('deleted_at')->where('section_id', $section_id)->count();
        Log::info(__FUNCTION__.' '.__LINE__.' out: '.$result);

        return $result;
    }

    public static function is_juror()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $is_juror = self::where('user_contact_id', Auth::id())->count();
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' jury counter:'.$is_juror);

        return $is_juror > 0;
    }

    // RELATIONSHIP

    public function contest_section()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $contest_section = $this->hasOne(ContestSection::class); // , 'id',             'section_id );
        // . . . . . . . . . . . . . . . . . . . . . .contest_sections.id   contest_jury.section_id
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contest:'.json_encode($contest_section));

        return $contest_section;
    }

    public function user_contact()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user_contact = $this->hasOne(UserContact::class, 'user_id', 'user_contact_id');
        // . . . . . . . . . . . . . . . . . .user_contacts.user_id   contest_juries.user_contact_id
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' user_contact:'.json_encode($user_contact));

        return $user_contact;
    }
}
