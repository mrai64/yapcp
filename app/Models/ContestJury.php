<?php

/**
 * Contest Jury is - for every section
 * the list of juror
 *
 * related to Contest
 * related to ContestSection
 * related to UserContact
 *
 * 2025-10-28 add is_juror
 * 2026-01-17 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ContestJury extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_juries';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //               pk but contest_juries.id IS NOT juror user_id
        'section_id', //       fk contest_sections.id
        'user_contact_id', //  fk user_contacts.user_id juror
        'is_president', //     Y/N not boolean
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];

    // no boolean
    private const VALID_YN = [
        'N', // 0 false
        'Y', // 1 true
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

    // VALIDATORS

    // was: is_valid_is_president
    public static function checkIsPresident(ContestJury $juror): bool
    {
        return in_array(
            needle: $juror->is_president,
            haystack: self::VALID_YN,
            strict: true
        );
    }

    // was: is_juror
    public static function checkIsJuror()
    {
        $check = self::where('user_contact_id', Auth::id())->count();

        return $check > 0;
    }


    // GETTERS

    // was: juror_list_for_section
    public static function sectionJurorsArray(string $sectionId): array
    {
        // was $juryCollection = self::whereNull('deleted_at')
        //         ->where('section_id', $section_id)->get(['id', 'user_contact_id']);
        $juryCollection = self::select('user_contact_id')
            ->where('section_id', $sectionId)
            ->get();

        // was $jurorsArray = [];
        //     foreach ($juryCollection as $juror) {
        //         $jurorsArray[] = $juror->user_contact_id;
        //     }
        $jurorsArray = array_values(collect($juryCollection)->toArray());

        return $jurorsArray;
    }

    // was: count_juror
    public static function jurorCount(string $sectionId): int
    {
        $jurorCount = self::where('section_id', $sectionId)->count();
        return $jurorCount;
    }

    // RELATIONS

    // was: contest_section
    // contest_juries.section_id > contest_sections.id
    public function contestSection()
    {
        $section = $this->belongsTo(ContestSection::class);

        return $section;
    }

    // was: user_contact
    public function userContact()
    {
        $contact = $this->belongsTo(
            related: UserContact::class, //   user_contacts
            foreignKey: 'user_contact_id', // contest_juries.user_contact_id
            ownerKey: 'user_id' //            user_contacts.user_id
        );

        return $contact;
    }
}
