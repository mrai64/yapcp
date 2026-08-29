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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $id
 * @property string $country_id fk: countries.id
 * @property string $name_en
 * @property string|null $name_local
 * @property string $lang_local dev: in LangList[]
 * @property string $organization_id fk: organizations.id
 * @property bool $is_circuit contests joined in circuit
 * @property string|null $circuit_id null or self fk: contests.id
 * @property string $federation_list free text for federation patronages
 * @property string|null $contest_mark The contest or organization passport photo - mark
 * @property string $contact_info contest headquarter, email and so on
 * @property string|null $award_ceremony_info Site and date, or link to broadcast platform
 * @property string|null $fee_info only text description of fee for participation
 * @property string $vote_rule fk: contests_vote_rule_sets.vote_rule
 * @property string|null $url_1_rule how read english rules and subscribe link
 * @property string|null $url_2_concurrent_list
 * @property string|null $url_3_admit_n_award_list only the result list, not a catalogue
 * @property string|null $url_4_catalogue catalogue download page
 * @property string $timezone_id fk: timezones.id
 * @property \Carbon\CarbonImmutable $day_1_opening T1 Reveal the contest, opening for subscription
 * @property \Carbon\CarbonImmutable $day_2_closing T2 >= T1 End of receive works
 * @property \Carbon\CarbonImmutable $day_3_jury_opening T3 > T2 Start of juror works
 * @property \Carbon\CarbonImmutable $day_4_jury_closing T4 >= T3 End of juror works
 * @property \Carbon\CarbonImmutable $day_5_revelations T5 > T4 Publicly result communications
 * @property \Carbon\CarbonImmutable $day_6_awards T6 > T5 Award Ceremony
 * @property \Carbon\CarbonImmutable $day_7_catalogues T7 > T6 Publicly Catalogue publications
 * @property \Carbon\CarbonImmutable $day_8_closing T8 > T7 Closing date for award postal send
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $awards
 * @property-read int|null $awards_count
 * @property-read Contest|null $circuit
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $contestAwards
 * @property-read int|null $contest_awards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Contest> $contestInCircuit
 * @property-read int|null $contest_in_circuit_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestPatronage> $contestPatronage
 * @property-read int|null $contest_patronage_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestSection> $contestSections
 * @property-read int|null $contest_sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVote> $contestVotes
 * @property-read int|null $contest_votes_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestWaitings
 * @property-read int|null $contest_waitings_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $contestWorks
 * @property-read int|null $contest_works_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Contest> $contestsInCircuit
 * @property-read int|null $contests_in_circuit_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $globalAwards
 * @property-read int|null $global_awards_count
 * @property-read \App\Models\Organization|null $organization
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestParticipant> $participants
 * @property-read int|null $participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestSection> $sections
 * @property-read int|null $sections_count
 * @property-read \App\Models\Timezone|null $timezone
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $waitings
 * @property-read int|null $waitings_count
 * @method static Builder<static>|Contest closedAfterOneYearAgo()
 * @method static \Database\Factories\ContestFactory factory($count = null, $state = [])
 * @method static Builder<static>|Contest newModelQuery()
 * @method static Builder<static>|Contest newQuery()
 * @method static Builder<static>|Contest onlyTrashed()
 * @method static Builder<static>|Contest query()
 * @method static Builder<static>|Contest whereAwardCeremonyInfo($value)
 * @method static Builder<static>|Contest whereCircuitId($value)
 * @method static Builder<static>|Contest whereContactInfo($value)
 * @method static Builder<static>|Contest whereContestMark($value)
 * @method static Builder<static>|Contest whereCountryId($value)
 * @method static Builder<static>|Contest whereCreatedAt($value)
 * @method static Builder<static>|Contest whereDay1Opening($value)
 * @method static Builder<static>|Contest whereDay2Closing($value)
 * @method static Builder<static>|Contest whereDay3JuryOpening($value)
 * @method static Builder<static>|Contest whereDay4JuryClosing($value)
 * @method static Builder<static>|Contest whereDay5Revelations($value)
 * @method static Builder<static>|Contest whereDay6Awards($value)
 * @method static Builder<static>|Contest whereDay7Catalogues($value)
 * @method static Builder<static>|Contest whereDay8Closing($value)
 * @method static Builder<static>|Contest whereDeletedAt($value)
 * @method static Builder<static>|Contest whereFederationList($value)
 * @method static Builder<static>|Contest whereFeeInfo($value)
 * @method static Builder<static>|Contest whereId($value)
 * @method static Builder<static>|Contest whereIsCircuit($value)
 * @method static Builder<static>|Contest whereLangLocal($value)
 * @method static Builder<static>|Contest whereNameEn($value)
 * @method static Builder<static>|Contest whereNameLocal($value)
 * @method static Builder<static>|Contest whereOrganizationId($value)
 * @method static Builder<static>|Contest whereTimezoneId($value)
 * @method static Builder<static>|Contest whereUpdatedAt($value)
 * @method static Builder<static>|Contest whereUrl1Rule($value)
 * @method static Builder<static>|Contest whereUrl2ConcurrentList($value)
 * @method static Builder<static>|Contest whereUrl3AdmitNAwardList($value)
 * @method static Builder<static>|Contest whereUrl4Catalogue($value)
 * @method static Builder<static>|Contest whereVoteRule($value)
 * @method static Builder<static>|Contest withTrashed(bool $withTrashed = true)
 * @method static Builder<static>|Contest withoutTrashed()
 * @mixin \Eloquent
 */

class Contest extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'contests'; // was: table_name but also Contest()->getTable()

    protected $fillable = [
        'id', //                        pk uuid
        'country_id', //                fk countries.id
        'name_en', //                   TODO become title
        'name_local', //                TODO remove field
        'lang_local', //                TODO remove field
        'organization_id', //           fk organizations.id
        'contest_mark', //              path n file
        'contact_info', //              free text
        'is_circuit', //                boolean
        'circuit_id',  //               fk contests.id | NULL
        'federation_list', //           TODO build validation rule
        'url_1_rule', //                web url
        'url_2_concurrent_list', //     web url
        'url_3_admit_n_award_list', //  web url
        'url_4_catalogue', //           web url
        'timezone_id', //                  fk timezones.id
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

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'name_en' => 'string',

            'is_circuit' => 'boolean',
            'circuit_id' => 'string',

            'country_id' => 'string',
            'lang_local' => 'string',
            'timezone_id' => 'string',

            'name_local' => 'string',
            'organization_id' => 'string',

            'federation_list' => 'string',
            'contest_mark' => 'string',
            'contact_info' => 'string',

            'award_ceremony_info' => 'string',
            'fee_info' => 'string',

            'vote_rule' => 'string',

            'url_1_rule'                => 'string',
            'url_2_concurrent_list'     => 'string',
            'url_3_admit_n_award_list'  => 'string',
            'url_4_catalogue'           => 'string',

            'day_1_opening'      => 'immutable_datetime',
            'day_2_closing'      => 'immutable_datetime',
            'day_3_jury_opening' => 'immutable_datetime',
            'day_4_jury_closing' => 'immutable_datetime',
            'day_5_revelations'  => 'immutable_datetime',
            'day_6_awards'       => 'immutable_datetime',
            'day_7_catalogues'   => 'immutable_datetime',
            'day_8_closing'      => 'immutable_datetime',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // INLINE check n replace
    protected static function booted(): void
    {
        // because '' is '', not null
        static::saving(function (Contest $contest): void {
            if (empty($contest->circuit_id)) {
                $contest->circuit_id = null;
            }
        });
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
            ->where('is_circuit', true)
            ->orderBy('name_en')
            ->get();

        return $circuitSet;
    }

    // for validation?
    public function contestIsInCircuit(): bool
    {
        return $this->is_circuit;
    }

    // fr validation?
    public function isACircuit(): bool
    {
        return $this->is_circuit;
    }


    // for circuit: get contest in circuit
    public function getContests(): HasMany
    {
        $contestSet = $this->hasMany(
            related: static::class,
            foreignKey: 'circuit_id',
            localKey: 'id'
        );

        return $contestSet;
    }

    // SCOPE - used to add filter to query

    /**
     * Scope for contests closed after-than-a-year ago
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeClosedAfterOneYearAgo(Builder $query): Builder
    {
        return $query->where('day_8_closing', '>', now()->subYear());
    }

    // RELATIONSHIPs

    // contests.country_id > countries.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Country, $this>
     */
    public function country(): BelongsTo
    {
        $country = $this->belongsTo(
            related:    Country::class, //   ext class
            foreignKey: 'country_id', //     int contests.country_id
            ownerKey:   'id' //              ext countries.id
        );
        // log
        return $country;
    }

    // federation list
    // TODO ContestPatronage

    // contests.timezone_id > timezones.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Timezone, $this>
     */
    public function timezone(): BelongsTo
    {
        //  = $this->belongsTo(Timezone::class);
        $tz = $this->belongsTo(
            related:    Timezone::class, //  ext class
            foreignKey: 'timezone_id', //    int contests.timezone_id
            ownerKey:   'id' //              ext timezones.id
        );

        return $tz;
    }

    // contests.organization_id > organizations.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<\App\Models\Organization, $this>
     */
    public function organization(): BelongsTo
    {
        $organization = $this->belongsTo(
            related: Organization::class,
            foreignKey: 'organization_id',
            ownerKey:   'id'
        );

        return $organization;
    }

    // valid for is_circuit 'Y'
    public function contestInCircuit(): HasMany
    {
        $contests = $this->hasMany(
            related: static::class,
            foreignKey: 'circuit_id',
            localKey: 'id'
        );

        return $contests;
    }

    // contest_juries.section_id > contest_sections.id > contests.id

    // contest_awards.contest_id > contests.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestAward, $this>
     */
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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestParticipant, $this>
     */
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
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestSection, $this>
     */
    public function contestSections(): HasMany
    {
        $sec = $this->hasMany(ContestSection::class);

        return $sec;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestSection, $this>
     */
    public function sections(): HasMany
    {
        $sec = $this->hasMany(ContestSection::class);
        // Log
        return $sec;
    }

    //
    // contest_votes
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestVote, $this>
     */
    public function contestVotes(): HasMany
    {
        $contestVotes = $this->hasMany(
            related: ContestVote::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestVotes;
    }

    // contest_waitings.contest_id contests.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestWaiting, $this>
     */
    public function contestWaitings(): HasMany
    {
        $contestWaitings = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWaitings;
    }

    // contest_waitings.contest_id contests.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestWaiting, $this>
     */
    public function waitings(): HasMany
    {
        $contestWaitings = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWaitings;
    }

    // contest_works
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestWork, $this>
     */
    public function contestWorks(): HasMany
    {
        $contestWorksSet = $this->hasMany(
            related: ContestWork::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );

        return $contestWorksSet;
    }

    // user_contests.contest_id contests.id
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\UserRole, $this>
     */
    public function userRoles(): HasMany
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
    public function circuit(): BelongsTo
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
     * @return HasMany
     */
    public function contestsInCircuit(): HasMany
    {
        $contests = $this->hasMany(
            related: static::class, //    contests
            foreignKey: 'circuit_id', //  contests.circuit_id
            localKey: 'id' //             contests.id
        );

        return $contests;
    }

    // all the awards
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestAward, $this>
     */
    public function awards(): HasMany
    {
        $awards = $this->hasMany(ContestAward::class)
            ->orderBy('section_id')
            ->orderBy('section_code')
            ->orderBy('award_code');
        // Log
        return $awards;
    }

    /**
     * Only the Contest award (no section == global award)
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestAward, $this>
     */
    public function globalAwards(): HasMany
    {
        $awards = $this->hasMany(ContestAward::class)
            ->whereNull('section_id')
            ->orderBy('award_code');
        // Log::debug("Richiesta relazione globalAwards per contest: " . $this->id);
        return $awards;
    }

    /**
     * Replace contests.federation_ist
     */
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\App\Models\ContestPatronage, $this>
     */
    public function contestPatronage(): HasMany
    {
        $contestPatronageSet = $this->hasMany(ContestPatronage::class);
        // Log
        return $contestPatronageSet;
    }
}
