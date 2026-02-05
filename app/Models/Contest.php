<?php

/**
 * Contest - *main table* with some info on contest like name,
 * calendar dates, federation
 *
 * 2025-09-17 In the photo contest organization some contest are grouped
 *            into so named circuit. A circuit have a contest record without
 *            section and jury. A circuit record
 * 2025-10-22 Created an auxiliary table and add col vote_rule
 * 2026-01-15 refactor for PSR-12 function n variables in camelCase
 *
 * related to ✅ Country
 * related to ❌ Federation (it's a federationId[patronageCode] list)
 * related to ✅ Timezone
 * related to ✅ Organization
 * related to 🚧 Contest (for circuit)
 * related to ✅ ContestAward
 * related to ✅ ContestParticipant
 * related to ✅ ContestSection
 * related to ✅ ContestVote
 * related to ✅ ContestWaiting
 * related to ✅ ContestWork
 * related to ✅ UserRole
 *
 * TODO refactor to reduce duplicate function
 * TODO manage local datetime, timezone to UTC
 * TODO manage UTC, Timezone to local datetime
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property string $id uuid assigned
 * @property string $country_id fk: countries.id
 * @property string $name_en
 * @property string|null $name_local
 * @property string $lang_local dev: in LangList[]
 * @property string $organization_id fk: organizations.id
 * @property string $is_circuit Y/N, N when not Y
 * @property string|null $circuit_id null or a valid contest.id
 * @property string|null $federation_list under patronage of federation code[]
 * @property string|null $contest_mark The contest or organization passport photo - mark
 * @property string $contact_info contest headquarter, email and so on
 * @property string|null $award_ceremony_info Site and date, or link to broadcast platform
 * @property string|null $fee_info only text description of fee for participation
 * @property string $vote_rule related to limited set
 * @property string|null $url_1_rule how read english rules and subscribe link
 * @property string|null $url_2_concurrent_list
 * @property string|null $url_3_admit_n_award_list only the result list, not a catalogue
 * @property string|null $url_4_catalogue catalogue download page
 * @property \App\Models\Timezone|null $timezone A MUST HAVE used for time math, must be a php valid timezone
 * @property \Illuminate\Support\Carbon $day_1_opening Reveal the contest, opening for subscription
 * @property \Illuminate\Support\Carbon $day_2_closing End of receive works
 * @property \Illuminate\Support\Carbon $day_3_jury_opening Start of juror works
 * @property \Illuminate\Support\Carbon $day_4_jury_closing End of juror works
 * @property \Illuminate\Support\Carbon $day_5_revelations Publicly result communications
 * @property \Illuminate\Support\Carbon $day_6_awards Award Ceremony
 * @property \Illuminate\Support\Carbon $day_7_catalogues Publicly Catalogue publications
 * @property \Illuminate\Support\Carbon $day_8_closing Closing date for award postal send
 * @property \Illuminate\Support\Carbon $created_at backup reserved
 * @property \Illuminate\Support\Carbon $updated_at backup reserved
 * @property \Illuminate\Support\Carbon|null $deleted_at softdelete reserved
 * @property-read Contest|null $circuit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $contestAwards
 * @property-read int|null $contest_awards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Contest> $contestInCircuit
 * @property-read int|null $contest_in_circuit_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVote> $contestVotes
 * @property-read int|null $contest_votes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestWaitings
 * @property-read int|null $contest_waitings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $contestWorks
 * @property-read int|null $contest_works_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Contest> $contestsInCircuit
 * @property-read int|null $contests_in_circuit_count
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestParticipant> $participants
 * @property-read int|null $participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestSection> $sections
 * @property-read int|null $sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $waitings
 * @property-read int|null $waitings_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereAwardCeremonyInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereCircuitId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereContestMark($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay1Opening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay2Closing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay3JuryOpening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay4JuryClosing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay5Revelations($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay6Awards($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay7Catalogues($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDay8Closing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereFederationList($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereFeeInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereIsCircuit($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereLangLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereNameLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereUrl1Rule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereUrl2ConcurrentList($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereUrl3AdmitNAwardList($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereUrl4Catalogue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest whereVoteRule($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contest withoutTrashed()
 * @mixin \Eloquent
 */


class Contest extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'contests'; // was: table_name but also Contest()->getTable()

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //                        pk uuid
        'country_id', //                fk countries.id
        'name_en', //                   TODO become title
        'name_local', //                TODO remove field
        'lang_local', //                TODO remove field
        'organization_id', //           fk organizations.id
        'contest_mark', //              path n file
        'contact_info', //              free text
        'is_circuit', //                0/1 N/Y limited set
        'circuit_id',  //               fk contests.id | NULL
        'federation_list', //           TODO build validation rule
        'url_1_rule', //                web url
        'url_2_concurrent_list', //     web url
        'url_3_admit_n_award_list', //  web url
        'url_4_catalogue', //           web url
        'timezone', //                  fk timezones.timezone
        'day_1_opening', //             datetime yyyy-mm-dd hh.mm UTC
        'day_2_closing', //             datetime yyyy-mm-dd hh.mm UTC
        'day_3_jury_opening', //        datetime yyyy-mm-dd hh.mm UTC
        'day_4_jury_closing', //        datetime yyyy-mm-dd hh.mm UTC
        'day_5_revelations', //         datetime yyyy-mm-dd hh.mm UTC
        'day_6_awards', //              datetime yyyy-mm-dd hh.mm UTC
        'day_7_catalogues', //          datetime yyyy-mm-dd hh.mm UTC
        'day_8_closing', //             datetime yyyy-mm-dd hh.mm UTC

        'award_ceremony_info', //       free text
        'fee_info', //                  free text

        'vote_rule', //                 fk contest_vote_rule_sets.vote_rule
        // 'contest_vote_rule_id', //   fk contest_vote_rules.id

        // created_at                   reserved
        // updated_at                   reserved
        // deleted_at                   reserved
    ];

    // uuid as pk
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid7();
        });
    }

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'country_id' => 'string',
            'name_en' => 'string',
            'name_local' => 'string',
            'lang_local' => 'string',
            'organization_id' => 'string',
            'is_circuit' => 'string',
            'circuit_id' => 'string',
            'federation_list' => 'string',
            'contest_mark' => 'string',
            'contact_info' => 'string',
            'award_ceremony_info' => 'string',
            'fee_info' => 'string',
            'vote_rule' => 'string',
            'url_1_rule' => 'string',
            'url_2_concurrent_list' => 'string',
            'url_3_admit_n_award_list' => 'string',
            'url_4_catalogue' => 'string',
            'timezone' => 'string',
            'day_1_opening' => 'datetime',
            'day_2_closing' => 'datetime',
            'day_3_jury_opening' => 'datetime',
            'day_4_jury_closing' => 'datetime',
            'day_5_revelations' => 'datetime',
            'day_6_awards' => 'datetime',
            'day_7_catalogues' => 'datetime',
            'day_8_closing' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERs

    public static function getNameEn(string $contestId): string
    {
        $getContest = self::find($contestId);

        return $getContest->name_en ?? '';
    }

    /**
     * Set of ordered contests w/is_circuit 1/Y, named circuits.
     * Warn: circuit set, not contest-in-circuit set
     */
    public static function getCircuitSet()
    {
        $circuitSet = self::select('id', 'name_en')
            ->where('is_circuit', 'Y')
            ->orderBy('name_en')
            ->get();

        return $circuitSet ?? [];
    }

    // for validation?
    public function contestIsInCircuit(): bool
    {
        $isIn = ($this->circuit_id !== null);
        return $isIn;
    }

    // fr validation?
    public function isACircuit(): bool
    {
        return ($this->is_circuit === 'Y');
    }


    // for circuit: get contest in circuit
    public function getContests()
    {
        $contestSet = $this->hasMany(
            related: static::class,
            foreignKey: 'circuit_id',
            localKey: 'id'
        );

        return $contestSet;
    }

    // RELATIONSHIPs

    // contests.country_id > countries.id
    public function country()
    {
        $country = $this->belongsTo(
            Country::class,
            'id',
            'country_id'
        );

        return $country;
    }

    // federation list

    // contests.timezone > timezones.id
    public function timezone()
    {
        $tz = $this->belongsTo(
            related: Timezone::class, // timezones
            foreignKey: 'id', //         timezones.id
            ownerKey: 'timezone' //      contests.timezone
        );

        return $tz;
    }

    // contests.organization_id > organizations.id
    public function organization()
    {
        $organization = $this->belongsTo(Organization::class);

        return $organization;
    }

    // valid for is_circuit 'Y'
    public function contestInCircuit()
    {
        $contests = $this->hasMany(
            related: static::class,
            foreignKey: 'id',
            localKey: 'circuit_id'
        );

        return $contests;
    }

    // contest_juries.section_id > contest_sections.id > contests.id

    // contest_awards.contest_id > contests.id
    public function contestAwards(): HasMany
    {
        $contestAwardsSet = $this->hasMany(
            related: ContestAward::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestAwardsSet;
    }

    // contest_participants.contest_id > contests.id
    public function participants(): HasMany
    {
        $participants = $this->hasMany(
            related: ContestParticipant::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $participants;
    }

    // contest_sections.contest_id > contests.id
    public function contestSections(): HasMany
    {
        $sec = $this->hasMany(ContestSection::class);

        return $sec;
    }

    public function sections(): HasMany
    {
        $sec = $this->hasMany(ContestSection::class);

        return $sec;
    }

    //
    // contest_votes
    public function contestVotes()
    {
        $contestVotes = $this->hasMany(
            related: ContestVote::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestVotes;
    }

    // contest_waitings.contest_id contests.id
    public function contestWaitings()
    {
        $contestWaitings = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWaitings;
    }

    // contest_waitings.contest_id contests.id
    public function waitings()
    {
        $contestWaitings = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWaitings;
    }

    // contest_works
    public function contestWorks()
    {
        $contestWorksSet = $this->hasMany(
            related: ContestWork::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWorksSet;
    }

    // user_contests.contest_id contests.id
    public function userRoles()
    {
        $userRoles = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $userRoles;
    }

    /**
     * For contest in circuit, self-referencing relation
     * to find circuit record over contest
     *
     * contests.circuit_id > contests.id
     */
    public function circuit()
    {
        $circuitId = $this->belongsTo(
            related: static::class, //    contests
            foreignKey: 'circuit_id', //  contests.circuit_id
            ownerKey: 'id' //             contests.id
        );

        return $circuitId;
    }

    /**
     * For contest in circuit, from circuit
     * to find contest under / circuit
     *
     * @return void
     */
    public function contestsInCircuit()
    {
        $contests = $this->hasMany(
            related: static::class, //    contests
            foreignKey: 'id', //          contests.id
            localKey: 'circuit_id' //     contests.circuit_id
        );

        return $contests;
    }

}
