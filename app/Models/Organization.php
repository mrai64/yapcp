<?php

/**
 * Organization | Organisation
 * They are Contest organizer
 *
 * related to Country
 * related to Contest
 * related to UserContact
 *
 * 2025-08-30 rename country_code in country_id, fk countries.id
 * 2025-10-15 fix organization_name()
 * 2025-12-17 add relationship country()
 * 2026-01-21 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property string $id uuid assigned
 * @property string $country_id
 * @property string $name
 * @property string $email Should became verified
 * @property string|null $website
 * @property string|null $contact postal address
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read int|null $contests_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @method static \Database\Factories\OrganizationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereContact($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Organization withoutTrashed()
 * @mixin \Eloquent
 */
class Organization extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'organizations';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //           pk uuid
        'country_id', //   fk countries.id
        'name', //         text
        'email', //        text
        'website', //      url official site
        'contact', //      secretary info
        // created_at      reserved
        // updated_at      reserved
        // deleted_at      reserved
    ];

    // uuid as pk
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
    }

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    /**
     * Sorted by
     *   - country_id
     *   - name
     *   - created_at (to avoid dup, theoretically not but in real world)
     * & exclusion for deleted_at
     */
    public static function countryIdSorted()
    {
        $organizations = DB::table('organizations')
            ->select('id', 'country_id', 'name', 'email', 'website')
            ->whereNull('deleted_at')
            ->orderBy('country_id', 'asc')
            ->orderBy('name', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        // log
        return $organizations;
    }

    // was: organization_name
    public static function organizationName(string $orgId): string
    {
        $organization = self::where('id', $orgId)->first();
        // log
        return $organization->name;
    }

    // RELATIONSHIP

    // organizations.country_id > countries.id
    public function country(): HasOne
    {
        $country = $this->hasOne(Country::class, 'id', 'country_id');
        // log
        return $country;
    }

    // organizations.id > contests.organization_id
    public function contests()
    {
        $contests = $this->hasMany(
            related: Contest::class,
            foreignKey: 'organization_id',
            localKey: 'id'
        );
        // log
        return $contests;
    }

    // organizations.id > user_roles.organization_id
    public function userRoles()
    {

        $userRoles = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'organization_id',
            localKey: 'id'
        );
        // log
        return $userRoles;
    }

}
