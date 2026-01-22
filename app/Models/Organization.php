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
