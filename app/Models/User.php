<?php

/**
 * Table generate by laravel installation and
 * modified to use uuid as primary key
 * 2025-08-31 id became uuid instead of bigint unsigned autoincrement
 * 2025-09-13 Notify users login w/email
 * 2025-10-13 User n UserContact are in relationship 1:1
 *            User n UserRole    are in relationship 1:N
 *            User n (User)Work  are in relationship 1:N
 * 2026-01-22 PSR-12
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // uuid booted()
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    // used to show a version number
    public const APPVERSION = '2025.12.1 dev';

    public const TABLENAME = 'users'; // MAYBE $this->table_name()

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id', //           pk bigint unsigned
        'name', //         test
        'email', //        mirrored in user_contacts
        'password', //     hashed
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // uuid as pk
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid7();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // GETTERS

    // RELATIONSHIPS
    // TODO most of that must be user_contacts.user_id >

    // users.id > contest_awards.winner_user_id
    public function awardWinners()
    {
        $awardWinnersSet = $this->hasMany(
            related: ContestAward::class,
            foreignKey: 'winner_user_id',
            localKey: 'id'
        );
        // log
        return $awardWinnersSet;
    }

    // users.id > contest_juries.user_contact_id
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

    // users.id > contest_participants.user_id
    public function contestParticipants()
    {
        $contestParticipants = $this->hasMany(
            related: ContestParticipant::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $contestParticipants;
    }

    // users.id > contest_votes.juror_user_id
    public function contestVotesJurors()
    {
        $cvjSet = $this->hasMany(related: ContestVote::class, foreignKey: 'juror_user_id', localKey: 'id');
        // log
        return $cvjSet;
    }

    // users.id > contest_waitings.participant_user_id
    public function contestParticipantsWaiting()
    {
        $cpwSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'participant_user_id',
            localKey: 'id'
        );
        // log
        return $cpwSet;
    }

    // users.id > contest_waitings.organization_user_id
    public function contestOrganizationsWaiting()
    {
        $cowSet = $this->hasMany(
            related: ContestWaiting::class,
            foreignKey: 'organization_user_id',
            localKey: 'id'
        );
        // log
        return $cowSet;
    }

    // users.id > contest_works.user_id
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

    // users.id > user_contact_mores.user_contact_user_id
    public function contactMores()
    {
        $cmSet = $this->hasMany(
            related: UserContactMore::class,
            foreignKey: 'user_contact_user_id',
            localKey: 'id'
        );
        // log
        return $cmSet;
    }

    // users.id > user_contacts.user_id
    public function contact()
    {
        $contact = $this->hasOne(
            related: UserContact::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $contact;
    }

    // users.id > user_contacts.user_id
    public function userContact()
    {
        $contact = $this->hasOne(
            related: UserContact::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $contact;
    }

    // users.id > user_roles.user_id
    public function roles()
    {
        $rSet = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $rSet;
    }

    // users.id > user_roles.user_id
    public function userRoles()
    {
        $rSet = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'user_id',
            localKey: 'id'
        );
        // log
        return $rSet;
    }

    // users.id > work_validators.validator_user_id
    public function workValidators()
    {
        $wvSet = $this->hasMany(
            related: WorkValidation::class,
            foreignKey: 'validator_user_id',
            localKey: 'id'
        );
        // log
        return $wvSet;
    }

    // users.id > works.user_id
    public function works()
    {
        $works = $this->hasMany(Work::class);
        // log
        return $works;
    }

}
