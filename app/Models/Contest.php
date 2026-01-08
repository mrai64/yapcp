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
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Contest extends Model
{
    use HasFactory, SoftDeletes;

    public const table_name = 'contests';

    // uuid as pk
    protected $keyType = 'string'; //     uuid string(36)

    public $incrementing = false; //   uuid don't need ++

    protected $fillable = [
        'id', //                 pk uuid
        'country_id', //         fk countries.id
        'name_en',
        'name_local',
        'lang_local',
        'organization_id', //    fk organizations.id
        'contest_mark', //       path n file
        'contact_info', //       text
        'is_circuit', //         Y/N limited set
        // circuit_id,  //       fk contests.id | NULL
        'federation_list', //
        'url_1_rule', //                web url
        'url_2_concurrent_list', //      web url
        'url_3_admit_n_award_list', //  web url
        'url_4_catalogue', //           web url
        // timezone, //                 fk timezones.timezone
        'day_1_opening',
        'day_2_closing',
        'day_3_jury_opening',
        'day_4_jury_closing',
        'day_5_revelations',
        'day_6_awards',
        'day_7_catalogues',
        'day_8_closing',
        'award_ceremony_info', //
        'fee_info', //
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
     * use: Contest::get_name_en(string $id)
     *
     * @return string name_en - contest name | ""
     */
    public static function get_name_en(string $contest_id): string
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $inp_id = Str::of($contest_id);
        $get_contest = self::select('name_en')->where('id', $inp_id)->get();
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' get: '.$get_contest);

        return (count($get_contest) == 0) ? '' : Str::of($get_contest[0]['name_en']);
    }

    /**
     * Used to fill blade.
     * Use: Contest::get_circuit_list()
     *
     * @return array [id, name_en] selection w/is_circuit Y/1/true
     */
    public static function get_circuit_list()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $circuit_list = self::select('id', 'name_en')
            ->where('is_circuit', 'Y')
            ->orderBy('name_en')
            ->get();

        return $circuit_list;
    }

    // RELATIONSHIPs

    /**
     * @return Country contests.country_id 1:1 countries.id
     */
    public function country()
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $country = $this->belongsTo(Country::class);
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out ');

        return $country;
    }

    /**
     * @return Organization contests.organization_id 1:1 organizations.id
     */
    public function organization(): HasOne
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $organization = $this->hasOne(Organization::class);
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out');

        return $organization;
    }

    /**
     * @return ContestSection contests.id 1:N contest_sections.contest_id
     */
    public function sections(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $sections = $this->hasMany(ContestSection::class);
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out');

        return $sections;
    }

    /**
     * @return ContestJuror contests.id 1:N contest_juries.contest_id
     */
    public function jury(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contest_jury_set = $this->hasMany(ContestJury::class);
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out ');

        return $contest_jury_set;
    }

    /**
     * @return ContestAwards contests.id 1:N contest_awards.contest_id
     */
    public function contest_awards(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $contest_awards_set = $this->hasMany(Country::class, 'contest_id', 'id');
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out ');

        return $contest_awards_set;
    }

    /**
     * @return ContestParticipant contests.id 1:N contest_participants.contest_id
     */
    public function participants(): HasMany
    {
        Log::info('Model '.__CLASS__.' f:'.__FUNCTION__.' l:'.__LINE__.' called');
        $participants = $this->hasMany(ContestParticipant::class, 'contest_id', 'id');
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' out');

        return $participants;
    }

    // contest_works

    // contest_votes
}
