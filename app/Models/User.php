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
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // uuid booted()
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property string $id uuid
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestAward> $awardWinners
 * @property-read int|null $award_winners_count
 * @property-read \App\Models\UserContact|null $contact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $contactMores
 * @property-read int|null $contact_mores_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestOrganizationsWaiting
 * @property-read int|null $contest_organizations_waiting_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestParticipant> $contestParticipants
 * @property-read int|null $contest_participants_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWaiting> $contestParticipantsWaiting
 * @property-read int|null $contest_participants_waiting_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestVote> $contestVotesJurors
 * @property-read int|null $contest_votes_jurors_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestWork> $contestWorks
 * @property-read int|null $contest_works_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestJury> $juries
 * @property-read int|null $juries_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\UserContact|null $userContact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWork> $works
 * @property-read int|null $works_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutTrashed()
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWorkValidation> $userWorkValidators
 * @property-read int|null $user_work_validators_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWork> $userWorks
 * @property-read int|null $user_works_count
 * @mixin \Eloquent
 */

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasUuids;
    use Notifiable;
    use SoftDeletes;

    public const TABLENAME = 'users'; // MAYBE $this->table_name()

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'id', //           pk bigint unsigned
        'name', //         test
        'email', //        mirrored in user_contacts
        'email_verified_at',
        'password', //     hashed
        'remember_token',
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
            'id' => 'string',
            'name' => 'string',
            'email' => 'string',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'remember_token' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
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

    // users.id > user_contacts.id
    public function contact()
    {
        $contact = $this->hasOne(
            related: UserContact::class,
            foreignKey: 'id',
            localKey: 'id'
        );
        // log
        return $contact;
    }

    // users.id > user_contacts.id
    public function userContact()
    {
        $contact = $this->hasOne(
            related: UserContact::class,
            foreignKey: 'id',
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

    // users.id > user_work_validators.validator_user_id
    public function userWorkValidators()
    {
        $wvSet = $this->hasMany(
            related: UserWorkValidation::class,
            foreignKey: 'validator_user_id',
            localKey: 'id'
        );
        // log
        return $wvSet;
    }

    // users.id > user_works.user_id
    public function userWorks()
    {
        $works = $this->hasMany(UserWork::class);
        // log
        return $works;
    }

    /**
     * Determine if the user has an active admin role.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->userRoles()
            ->where('role', UserRole::ADMINGROUP)
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
    }

    /**
     * Determine if the user is registered for a specific organization.
     *
     * @param Organization|string $organization Organization instance or organization id string
     * @return bool
     */
    public function isMemberOfOrganization(Organization|string $organization): bool
    {
        $organizationId = $organization instanceof Organization ? $organization->id : $organization;

        return $this->userRoles()
            ->where('organization_id', $organizationId)
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
    }

    /**
     * Determine if the user is member of any Organization
     *
     * @return bool
     */
    public function isMemberOfAnyOrganization(): bool
    {
        return $this->userRoles()
            ->whereNotNull('organization_id')
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
    }

    /**
     * Determine if the user is registered for a specific federation.
     *
     * @param Federation|string $federation Federation instance or federation string Id
     * @return bool
     */
    public function isMemberOfFederation(Federation|string $federation): bool
    {
        $federationId = $federation instanceof Federation ? $federation->id : $federation;

        return $this->userRoles()
            ->where('federation_id', $federationId)
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
    }

    /**
     * Determine how many works are available in user gallery
     * 
     * @return int
     */
    public function worksCount(): int
    {
        return $this->userWorks()->count();
    }

}
