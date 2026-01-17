<?php

/**
 * Contest - main table
 * must be father of seven
 * use uuid
 * related of Organization
 *
 * 2025-09-17 In the photo contest organization some contest are grouped
 *            into so named circuit. A circuit have a contest record without
 *            section and jury. A circuit record
 * 2025-10-22 Created an auxiliary table and add col vote_rule
 * 2026-01-15 refactor for PSR-12 function n variables in camelCase
 *
 * relations
 * 1:1 contests.country_id > countries.id
 * 1:1 contests.organization_id > organizations.id
 * N:1 contests.circuit_id > contests.id (with is_circuit == 1)
 * 1:N contests.id < contest_awards.contest_id
 * 1:N contests.id < contest_participants.contest_id
 * 1:N contests.id < contest_sections.contest_id
 * 1:N contests.id < contest_votes.contest_id
 * 1:N contests.id < contest_waitings.contest_id
 * 1:N contests.id < contest_works.contest_id
 * 1:N contests.id < user_roles.contest_id
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Contest extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contests'; // was: table_name

    // uuid as pk
    protected $keyType = 'string'; //     uuid string(36)

    public $incrementing = false; //   uuid don't need ++

    protected $fillable = [
        'id', //                 pk uuid
        // contest 'name'
        'country_id', //         fk countries.id
        'name_en',
        'federation_list', // TODO build validation rule
        'name_local', // TODO remove field
        'lang_local', // TODO remove field
        'contest_mark', //       path n file
        'timezone', //                  fk timezones.timezone
        'organization_id', //    fk organizations.id
        // circuit part
        'is_circuit', //         Y/N limited set
        'circuit_id',  //        fk contests.id | NULL
        //
        'url_1_rule', //                web url
        'url_2_concurrent_list', //     web url
        'url_3_admit_n_award_list', //  web url
        'url_4_catalogue', //           web url
        'day_1_opening',
        'day_2_closing',
        'day_3_jury_opening',
        'day_4_jury_closing',
        'day_5_revelations',
        'day_6_awards',
        'day_7_catalogues',
        'day_8_closing',
        // info block
        'contact_info', //       text
        'award_ceremony_info', //
        'fee_info', //
        // jury block
        'vote_rule', //                 fk contest_vote_rule_sets.vote_rule
        // 'contest_vote_rule_id', //   fk contest_vote_rules.id

        // created_at
        // updated_at
        // deleted_at
    ];

    // uuid as pk
    public static function booted()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid7(); // uuid generator
        });
    }

    protected function casts()
    {
        // Log::info('Model '. __CLASS__ .' f:'. __FUNCTION__ .' l:'. __LINE__ .' called');
        return [
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

    /**
     * use: Contest::getNameEn(string $id)
     *
     * @return string name_en - contest name | ""
     */
    public static function getNameEn(string $contestId): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $inpId = Str::of($contestId);
        $getContest = self::select('name_en')->where('id', $inpId)->get();
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' get: '.$getContest);

        return (count($getContest) == 0) ? '' : Str::of($getContest[0]['name_en']);
    }

    /**
     * Used to fill blade.
     * Use: Contest::get_circuit_list()
     *
     * @return array [id, name_en] selection w/is_circuit Y/1/true
     *
    public static function get_circuit_list()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $circuit_list = self::select('id', 'name_en')
            ->where('is_circuit', 'Y')
            ->orderBy('name_en')
            ->get();

        return $circuit_list;
    }
     */

    // RELATIONSHIPs

    /**
     * @return Country contests.country_id 1:1 countries.id
     */
    public function country()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $country = $this->belongsTo(Country::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out');

        return $country;
    }

    /**
     * @return Organization contests.organization_id 1:1 organizations.id
     */
    public function organization()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $organization = $this->belongsTo(Organization::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out');

        return $organization;
    }

    /**
     * @return ContestAwards contests.id 1:N contest_awards.contest_id
     */
    public function contestAwards(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contestAwardsSet = $this->hasMany(related: Country::class, foreignKey: 'contest_id', localKey: 'id');
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out ');

        return $contestAwardsSet;
    }

    /**
     * @return ContestJuror contests.id 1:N contest_juries.contest_id
     */
    public function jury()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contestJurySet = $this->hasMany(ContestJury::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out');

        return $contestJurySet;
    }

    /**
     * @return ContestParticipant contests.id 1:N contest_participants.contest_id
     */
    public function participants(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $participants = $this->hasMany(
            related: ContestParticipant::class,
            foreignKey: 'contest_id',
            localKey: 'id'
        );
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out');

        return $participants;
    }

    /**
     * @return ContestSection contests.id 1:N contest_sections.contest_id
     */
    public function sections()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $sections = $this->hasMany(ContestSection::class);
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' out');

        return $sections;
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

}
