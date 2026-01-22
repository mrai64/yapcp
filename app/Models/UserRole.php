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
use Illuminate\Support\Facades\Log;

class UserRole extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'user_roles';

    // protected $primaryKey 'id'        standard
    // protected $keyType = unsigned int standard
    // public $incrementing = true       standard

    protected $fillable = [
        'id', //               pk bigint autoincrement
        'user_id', //          fk user_contacts.user_id users.id
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

    // was: valid_roles
    public static function validRoles()
    {
        $valid = UserRolesRoleSet::validRoles();
        // log
        return $valid;
    }

    // RELATIONS

    // ws: user_contact
    public function userContact()
    {
        $userContact = $this->belongsTo(
            UserContact::class,
            'user_id',
            'user_id'
        );
        // log
        return $userContact;
    }

    public function federation()
    {
        $federation = $this->belongsTo(
            Federation::class,
            'id',
            'federation_id'
        );
        // log
        return $federation;
    }

    public function organization()
    {
        $organization = $this->belongsTo(
            Organization::class,
            'id',
            'organization_id'
        );
        // log
        return $organization;
    }

    public function contest()
    {
        $contest = $this->belongsTo(
            Contest::class,
            'contest_id',
            'id'
        );
        // log
        return $contest;
    }
}
