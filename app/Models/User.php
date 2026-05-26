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

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // uuid booted()
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    /** @use HasFactory<UserFactory> */
    use HasFactory;
    use HasUuids;
    use HasProfilePhoto;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    public const TABLENAME = 'users'; // MAYBE $this->table_name()

    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment


    /**
     * The attributes that are mass assignable.
     *
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    // uuid as pk
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid7();
        });
    }

    /**
     * The accessors to append to the model's array form.
     *
     */
    protected $appends = [
        'profile_photo_url',
    ];

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

    // users.id > contest_awards.winner_user_id
    public function awardWinners(): HasMany
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
    public function juries(): HasMany
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
    public function contestParticipants(): HasMany
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
    public function contestVotesJurors(): HasMany
    {
        $cvjSet = $this->hasMany(
            related: ContestVote::class,
            foreignKey: 'juror_user_id',
            localKey: 'id'
        );
        // log
        return $cvjSet;
    }

    // users.id > contest_waitings.participant_user_id
    public function contestParticipantsWaiting(): HasMany
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
    public function contestOrganizationsWaiting(): HasMany
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
    public function contestWorks(): HasMany
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
    public function contactMores(): HasMany
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
    public function contact(): HasOne
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
    public function userContact(): HasOne
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
    public function userRoles(): HasMany
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
    public function userWorkValidators(): HasMany
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
    public function userWorks(): HasMany
    {
        $works = $this->hasMany(UserWork::class);
        // log
        return $works;
    }

    // IS?

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
     * Determine if the user is registered as juror in a specific contest.
     *
     * @return bool
     */
    public function isJurorInAContest(ContestSection|string $section): bool
    {
        $contestId = $section instanceof ContestSection ? $section->contest_id : ContestSection::find($section);

        return $this->userRoles()
            ->where('contest_id', $contestId)
            ->where('role', UserRole::JUROR)
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

    public function userWorksCount(): int
    {
        return $this->userWorks()->count();
    }


}
