<?php

/**
 * Users in platform should be: contest participant,
 * organization members, or federation members, or admin...
 *
 * 2025-10-10 created an auxiliary table user_roles_role_set to manage
 *            previously value of valid_roles[]
 * 2025-10-18 user_roles had a 1:1: relationship w/user_roles_role_sets
 * 2026-01-22 PSR-12
 *
 * TODO evaluate column 'type' ('contest', 'federation', 'organization' )
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * @property int $id
 * @property string $user_id fk: users.id
 * @property string $role
 * @property string|null $organization_id fk: organizations.id
 * @property string|null $contest_id fk: contests.id
 * @property string|null $federation_id fk to federations.id
 * @property \Illuminate\Support\Carbon $role_opening Start of role works - default today
 * @property \Illuminate\Support\Carbon $role_closing End of role works default:future
 * @property \Illuminate\Support\Carbon $created_at backup reserved
 * @property \Illuminate\Support\Carbon $updated_at backup reserved
 * @property \Illuminate\Support\Carbon|null $deleted_at softdelete reserved
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\Federation|null $federation
 * @property-read \App\Models\Organization|null $organization
 * @property-read \App\Models\UserContact|null $userContact
 * @method static \Database\Factories\UserRoleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereFederationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereOrganizationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRole($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRoleClosing($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereRoleOpening($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserRole withoutTrashed()
 * @mixin \Eloquent
 */
class UserRole extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_roles';
    public const ADMINGROUP = 'admin';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //               pk bigint autoincrement
        'user_id', //          fk user_contacts.id users.id
        'role', //             fk user_roles_role_sets.role
        'organization_id', //  fk organizations.id  nullable
        'contest_id', //       fk contests.id       nullable
        'federation_id', //    fk federations.id    nullable
        'role_opening', //     datetime
        'role_closing', //     datetime >= role_opening
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];

    protected function casts()
    {
        return [
            'id' => 'int',
            'user_id' => 'string',
            'role' => 'string',
            'organization_id' => 'string',
            'contest_id' => 'string',
            'federation_id' => 'string',
            'role_opening' => 'datetime',
            'role_closing' => 'datetime',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // was: only_one_role
    // Only one, not 0, 2 or 3
    public function onlyOneRole(UserRole $userRole): bool
    {
        $present  = ($userRole->organization_id === null) ? 0 : 1;
        $present += ($userRole->contest_id      === null) ? 0 : 1;
        $present += ($userRole->federation_id   === null) ? 0 : 1;
        // log
        return ($present === 1);
    }

    // GETTERS

    // was: valid_roles
    public static function validRoles()
    {
        $valid = UserRolesRoleSet::validRoles();
        // log
        return $valid;
    }

    // user_id is based on logged user
    public static function isAdmin(): bool
    {
        $examine = self::where('user_id', Auth::id())
            ->where('role', self::ADMINGROUP)
            ->where('role_opening', '<=', now())
            ->where('role_closing', '>=', now())
            ->exists();
        ds($examine);
        return $examine;
    }

    // RELATIONS

    // ws: user_contact
    public function userContact()
    {
        $userContact = $this->belongsTo(
            UserContact::class, // ext  class
            'user_id', //          int  user_roles.user_id
            'id' //                ext  user_contacts.id
        );
        // log
        return $userContact;
    }

    public function federation()
    {
        $federation = $this->belongsTo(
            Federation::class, //  ext  class
            'federation_id', //    int  user_roles.federation_id
            'id' //                ext  federations.id
        );
        // log
        return $federation;
    }

    public function organization()
    {
        $organization = $this->belongsTo(
            Organization::class, // ext class
            'organization_id', //   int user_roles.organization_id
            'id' //                 ext organizations_id
        );
        // log
        return $organization;
    }

    public function contest()
    {
        $contest = $this->belongsTo(
            Contest::class, //  ext  class
            'contest_id', //    int  user_roles.contest_id
            'id' //             ext  contests.id
        );
        // log
        return $contest;
    }
}
