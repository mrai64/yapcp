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

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @property string $id reak pk section_id + juror user_id
 * @property string $contest_id fk: contests.id
 * @property string $section_id fk: contest_sections.id
 * @property string $user_id fk: user_contacts.id - juror
 * @property bool $is_president used to put first in juror list
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\ContestSection|null $contestSection
 * @property-read \App\Models\UserContact|null $userContact
 * @method static \Database\Factories\ContestJuryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereIsPresident($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestJury withoutTrashed()
 * @mixin \Eloquent
 */
class ContestJury extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'contest_juries';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //               pk but contest_juries.id IS NOT juror user_id
        'contest_id', //       fk contest.id
        'section_id', //       fk contest_sections.id
        'user_id', //          fk user_contacts.user_id juror
        'is_president', //     boolean
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'string',
            'contest_id' => 'string',
            'section_id' => 'string',
            'user_id' => 'string',
            'is_president' => 'boolean',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // VALIDATORS

    // was: is_valid_is_president
    public static function checkIsPresident(ContestJury $juror): bool
    {
        return (bool) $juror->is_president;
    }

    // was: is_juror
    public static function checkIsJuror()
    {
        $check = self::where('user_id', Auth::id())->count();

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

    // can also be contest_juries N>1 contest_sections N>1 contests
    // contest_juries N>1 contests
    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }

    // was: contest_section
    // contest_juries.section_id > contest_sections.id
    public function contestSection(): BelongsTo
    {
        $section = $this->belongsTo(ContestSection::class);

        return $section;
    }

    // was: user_contact
    public function userContact(): BelongsTo
    {
        $contact = $this->belongsTo(
            related: UserContact::class, //   user_contacts
            foreignKey: 'user_id', //         contest_juries.user_contact_id
            ownerKey: 'id' //                 user_contacts.id
        );

        return $contact;
    }
}
