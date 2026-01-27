<?php

/**
 * User Contacts id the directory of all the people involved into
 * the platform in various roles. Are you a participants?
 * Are you a Organization member? Are you a Federation controller?
 *
 * user_id as uuid() should be primary key also for user_contact
 * 2025-09-03 photo_box where store user works and passport_photo
 * 2025-09-10 add timezone and lang_local (for search: local_lang)
 * 2025-09-21 add getter functions
 * 2025-10-26 add relationship w/country
 * 2026-01-22 PSR-12
 *
 * TODO manage file name as database label for file named uuid
 * TODO manage first_name last_name
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class UserContact extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_contacts';

    // attributes mass assignable in factory and seeder
    protected $fillable = [
        'id', //               pk bigint autoincrement
        'user_id', //          fk users.id
        'country_id', //       fk countries.id
        'first_name', //       text
        'last_name', //        text
        'nick_name', //        text
        'email', //            synchro users.email
        'cellular', //         w/international prefix
        'passport_photo', //   small jpg in /photo_box/__passport_photo.jpg
        'address', //          postal first line
        'address_line2', //    postal
        'city', //             postal
        'region', //           postal
        'postal_code', //      postal
        'lang_local', //       reserved TODO future use
        'timezone', //         TODO timezone_id fk timezones.id
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
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * @return the string used to store works and passport_photo
     */
    // was: photo_box
    public function photoBox(): string
    {

        /*
         * was
        $pb = $this->country_id.'/'
        .$this->last_name.'/'
        .$this->first_name.'_'
        .$this->user_id; // substr( $this->id, 0, 4);

        $pb = str_ireplace(':', '-', $pb);
        $pb = str_ireplace('+', '', $pb);
        $pb = str_ireplace(' ', '-', $pb);
         * 
         */

        $pb  = $this->country_id . '/';
        $pb .= Str::slug($this->last_name) . '/';
        $pb .= Str::slug($this->first_name) . '_';
        $pb .= $this->user_id;

        return $pb;
    }

    // GETTERS

    /**
     * get photo_box folder name
     */
    // was: get_photo_box
    public static function getPhotoBox(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $uc = self::where('user_id', $uid)->firstOrFail();
        // compose pb
        $photoBox = $uc->country_id.'/'.$uc->last_name.'/'.$uc->first_name.'_'.$uc->user_id;
        $photoBox = str_ireplace(':', '-', $photoBox);
        $photoBox = str_ireplace('+', '', $photoBox);
        $photoBox = str_ireplace(' ', '-', $photoBox);

        return $photoBox;
    }

    /**
     * @return string first name last name / country_id
     */
    //was: get_first_last_name
    public static function getFirstLastName(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->first();

        return $user->first_name.' '.$user->last_name.' /'.$user->country_id;
    }

    // was: get_last_first_name
    public static function getLastNFirstName(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->first();

        return $user->last_name.' '.$user->first_name.' /'.$user->country_id;
    }

    // was: get_email
    public static function getEmail(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->get('email')[0];

        return $user['email'];
    }

    // was: get_first_name
    public static function getFirstName(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->get('first_name')[0];

        return $user['first_name'];
    }

    // was: get_last_name
    public static function getLastName(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->get('last_name')[0];

        return $user['last_name'];
    }

    // was: get_country_id
    public static function getCountryId(string $uid): string
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $user = self::where('user_id', $uid)->get('country_id')[0];

        return $user['country_id'];
    }

    // RELATIONSHIP

    // user_contacts.user_id > contest_awards.winner_user_id
    public function contestAwards()
    {
        $contestAwardsWinnersSet = $this->hasMany(
            related: ContestAward::class,
            foreignKey: 'winner_user_id',
            localKey: 'user_id'
        );
        // log
        return $contestAwardsWinnersSet;
    }

    // user_contacts.user_id > contest_juries.user_contact_id
    public function contestJurors()
    {
        $contestJurorsSet = $this->hasMany(
            related: ContestJury::class,
            foreignKey: 'user_contact_id',
            localKey: 'user_id'
        );
        // log
        return $contestJurorsSet;
    }

    public function juries()
    {
        $juries = $this->hasMany(
            related: ContestJury::class,
            foreignKey: 'user_contact_id',
            localKey: 'user_id'
        );
        // log
        return $juries;
    }

    // user_contacts.user_id > contest_participants.user_id
    public function contestParticipants()
    {
        $contestParticipantsSet = $this->hasMany(
            related: ContestParticipant::class,
            foreignKey: 'user_id',
            localKey: 'user_id'
        );
        // log
        return $contestParticipantsSet;
    }

    // user_contacts.user_id > contest_votes.juror_user_id
    public function contestVotesJuror()
    {
        $cvjSet = $this->hasMany(
            related:  ContestVote::class,
            foreignKey: 'juror_user_id',
            localKey: 'user_id'
        );
        // log
        return $cvjSet;
    }

    // user_contacts.user_id > contest_waitings.participant_user_id
    public function contestWaitingParticipants()
    {
        $cwpSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'participant_user_id',
            localKey: 'user_id'
        );
        // log
        return $cwpSet;
    }

    // user_contacts.user_id > contest_waitings.organization_user_id
    public function contestWaitingOrganizations()
    {
        $cwoSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'organization_user_id',
            localKey: 'user_id'
        );
        // log
        return $cwoSet;
    }

    // user_contacts.user_id > contest_works.user_id
    public function contestWorks()
    {
        $cwSet = $this->hasMany(
            related: ContestWork::class,
            foreignKey: 'user_id',
            localKey: 'user_id'
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

    // user_contacts.user_id > user_contact_mores.user_contact_user_id
    public function contactMores()
    {
        $contactMores = $this->hasMany(
            UserContactMore::class,
            'user_contact_user_id',
            'user_id'
        );
        // log
        return $contactMores;
    }

    // user_contacts.id > user_contacts.id
    // user_contacts.user_id > user_contacts.user_id

    // user_contacts.user_id > user_roles.user_id
    public function userRoles()
    {
        $userRoles = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'user_id',
            localKey: 'user_id'
        );
        // loc
        return $userRoles;
    }

    // user_contacts.user_id > users.id
    public function user()
    {
        $user = $this->belongsTo(
            related: User::class,
            foreignKey: 'id',
            ownerKey: 'user_id'
        );
        // log
        return $user;
    }

    // user_contacts.user_id > work_validations.validator_user_id
    public function workValidators()
    {
        $wvSet = $this->hasMany(
            related: WorkValidation::class,
            foreignKey: ' validator_user_id',
            localKey: 'user_id'
        );
        // log
        return $wvSet;
    }

    // contest_contacts.user_id > works.user_id
    public function userWorks()
    {
        $uwSet = $this->hasMany(
            related: Work::class,
            foreignKey: 'user_id',
            localKey: 'user_id'
        );
        // log
        return $uwSet;
    }
}
