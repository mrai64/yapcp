<?php

/**
 * User Contacts id the directory of all the people involved into
 * the platform in various roles. Are you a participants?
 * Are you a Organization member? Are you a Federation controller?
 *
 * user_id as uuid() should be primary key also for user_contact
 * 2025-09-03 photo_box where store user works and passport_photo
 * 2025-09-10 add timezone_id and lang_local (for search: local_lang)
 * 2025-09-21 add getter functions
 * 2025-10-26 add relationship w/country
 * 2026-01-22 PSR-12
 *
 * TODO manage file name as database label for file named uuid
 * TODO manage first_name last_name
 * 2026-02-21 user_id become id and pk
 */

namespace App\Models;

use App\Casts\Country3Id;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property string $id fk: users.id uuid
 * @property string $country_id fk: countries.id
 * @property string $first_name
 * @property string $last_name
 * @property string|null $nick_name
 * @property string $email same as users.email
 * @property string $cellular
 * @property string $passport_photo
 * @property string $lang_local for future use - html lang
 * @property string $timezone_id for future use - php timezone for time math
 * @property string $address
 * @property string $address_line2
 * @property string $city
 * @property string $region
 * @property string $postal_code
 * @property string|null $website url of personal site
 * @property string|null $facebook url of personal page
 * @property string|null $x_twitter url of personal page
 * @property string|null $instagram url of personal page
 * @property string|null $whatsapp to chat into
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $contactMores
 * @property-read int|null $contact_mores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $contestAwards
 * @property-read int|null $contest_awards_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestJury> $contestJurors
 * @property-read int|null $contest_jurors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestParticipant> $contestParticipants
 * @property-read int|null $contest_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVote> $contestVotesJuror
 * @property-read int|null $contest_votes_juror_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestWaitingOrganizations
 * @property-read int|null $contest_waiting_organizations_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestWaitingParticipants
 * @property-read int|null $contest_waiting_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $contestWorks
 * @property-read int|null $contest_works_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestJury> $juries
 * @property-read int|null $juries_count
 * @property-read \App\Models\User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWork> $userWorks
 * @property-read int|null $user_works_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\WorkValidation> $workValidators
 * @property-read int|null $work_validators_count
 * @method static \Database\Factories\UserContactFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereAddressLine2($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereCellular($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereLangLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereNickName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact wherePassportPhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact wherePostalCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereTimezone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereWhatsapp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact whereXTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContact withoutTrashed()
 * @property string $timezone for future use - php timezone for time math
 * @mixin \Eloquent
 */
class UserContact extends Model
{
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'user_contacts';

    // attributes mass assignable in factory and seeder
    protected $fillable = [
        'id', //               uuid === fk users.id uuid
        'country_id', //       fk countries.id CHAR3UPPER
        'first_name', //       text
        'last_name', //        text
        'nick_name', //        text
        'email', //            synchro users.email
        'cellular', //         E.164 format w/international prefix
        'passport_photo', //   ICAO small jpg in /photo_box/__passport_photo.jpg
        'address', //          postal first line
        'address_line2', //    postal
        'city', //             postal
        'region', //           postal
        'postal_code', //      postal
        'lang_local', //       reserved TODO future use
        'timezone_id', //      fk timezones.id
        'website', //          url
        'facebook', //         url
        'x_twitter', //        url
        'instagram', //        url
        'whatsapp', //         url
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'string',
            //
            'country_id' => Country3Id::class,
            'first_name' => 'string',
            'last_name' => 'string',
            'nick_name' => 'string',
            'email' => 'string',
            'cellular' => 'string',
            'passport_photo' => 'string',
            //
            'address' => 'string',
            'address_line2' => 'string',
            'city' => 'string',
            'region' => 'string',
            'postal_code' => 'string',
            'lang_local' => 'string',
            'timezone_id' => 'string',
            //
            'website' => 'string',
            'facebook' => 'string',
            'x_twitter' => 'string',
            'instagram' => 'string',
            'whatsapp' => 'string',
            //
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * @return the string used to store works and passport_photo
     * Note: users.id to avoid homonymies
     */
    // was: photo_box
    public function photoBox(): string
    {
        // ITA/Verdi/Giuseppe_12345678-1234-1234-1234-123456789012
        $pb = Str::upper($this->country_id) . '/'
            . Str::slug($this->last_name) . '/'
            . Str::slug($this->first_name) . '_'
            . Str::lower($this->id);

        return $pb;
    }

    // GETTERS

    /**
     * get photo_box folder name
     */
    // was: get_photo_box
    public static function getPhotoBox(string $uid): string
    {
        $uc = self::where('id', $uid)->firstOrFail();
        // compose pb
        $photoBox = Str::upper($uc->country_id) . '/'
            . Str::slug($uc->last_name) . '/'
            . Str::slug($uc->first_name) . '_'
            . Str::lower($uc->id);

        return $photoBox;
    }

    /**
     * @return string first name last name / country_id
     */
    //was: get_first_last_name
    public static function getFirstLastName(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->first();

        return $user->first_name.' '.$user->last_name.' /'.$user->country_id;
    }

    // was: get_last_first_name
    public static function getLastNFirstName(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->first();

        return $user->last_name.' '.$user->first_name.' /'.$user->country_id;
    }

    // was: get_email
    public static function getEmail(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->get('email')[0];

        return $user['email'];
    }

    // was: get_first_name
    public static function getFirstName(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->get('first_name')[0];

        return $user['first_name'];
    }

    // was: get_last_name
    public static function getLastName(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->get('last_name')[0];

        return $user['last_name'];
    }

    // was: get_country_id
    public static function getCountryId(string $uid): string
    {
        ds('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('id', $uid)->get('country_id')[0];

        return $user['country_id'];
    }

    // RELATIONSHIP

    // user_contacts.id > contest_awards.winner_user_id
    public function contestAwards()
    {
        $contestAwardsWinnersSet = $this->hasMany(
            related: ContestAward::class,
            foreignKey: 'winner_user_id',
            localKey: 'id'
        );
        // log
        return $contestAwardsWinnersSet;
    }

    // user_contacts.id > contest_juries.user_contact_id
    public function contestJurors()
    {
        $contestJurorsSet = $this->hasMany(
            related: ContestJury::class,
            foreignKey: 'user_contact_id',
            localKey: 'id'
        );
        // log
        return $contestJurorsSet;
    }

    public function juries()
    {
        $juries = $this->hasMany(
            related: ContestJury::class,
            foreignKey: 'user_contact_id',
            localKey: 'id'
        );
        // log
        return $juries;
    }

    // user_contacts.id > contest_participants.user_id
    public function contestParticipants()
    {
        $contestParticipantsSet = $this->hasMany(
            related: ContestParticipant::class,
            foreignKey: 'user_id', //  contest_participants.user_id
            localKey: 'id' //          user_contacts.id
        );
        // log
        return $contestParticipantsSet;
    }

    // user_contacts.id > contest_votes.juror_user_id
    public function contestVotesJuror()
    {
        $cvjSet = $this->hasMany(
            related:  ContestVote::class,
            foreignKey: 'juror_user_id',
            localKey: 'id'
        );
        // log
        return $cvjSet;
    }

    // user_contacts.id > contest_waitings.participant_user_id
    public function contestWaitingParticipants()
    {
        $cwpSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'participant_user_id',
            localKey: 'id'
        );
        // log
        return $cwpSet;
    }

    // user_contacts.id > contest_waitings.organization_user_id
    public function contestWaitingOrganizations()
    {
        $cwoSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'organization_user_id',
            localKey: 'id'
        );
        // log
        return $cwoSet;
    }

    // user_contacts.id > contest_works.user_id
    public function contestWorks()
    {
        $cwSet = $this->hasMany(
            related: ContestWork::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $cwSet;
    }

    // user_contacts.country_id > countries.id
    public function country()
    {
        $country = $this->belongsTo(
            related: Country::class, //   countries.
            foreignKey: 'country_id', //  user_contacts.country_id
            ownerKey: 'id' //             countries.id
        );
        return $country;
    }

    // user_contacts.id > user_contact_mores.user_contact_user_id
    public function contactMores()
    {
        $contactMores = $this->hasMany(
            UserContactMore::class,
            'user_contact_user_id',
            'id'
        );
        // log
        return $contactMores;
    }

    // user_contacts.id > user_contacts.id
    // user_contacts.id > user_contacts.user_id

    // user_contacts.id > user_roles.user_id
    public function userRoles()
    {
        $userRoles = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // loc
        return $userRoles;
    }

    // user_contacts.id > users.id
    public function user()
    {
        $user = $this->belongsTo(
            related: User::class,
            foreignKey: 'id',
            ownerKey: 'id'
        );
        // log
        return $user;
    }

    // user_contacts.id > work_validations.validator_user_id
    public function workValidators()
    {
        $wvSet = $this->hasMany(
            related: WorkValidation::class,
            foreignKey: ' validator_user_id',
            localKey: 'id'
        );
        // log
        return $wvSet;
    }

    // contest_contacts.id > works.user_id
    public function userWorks()
    {
        $uwSet = $this->hasMany(
            related: Work::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $uwSet;
    }

    //
}
