<?php

/**
 * Federation are the organization that define rules for well
 * conducted photographic contest and need report to manage some
 * distinctions based on contest results.
 * As key is acronym based, some federation had
 * the same code, in that case a suffix must be added
 * i.e. FAF:AND Federation Andorrana de Fotografia
 *      FAF:ARG Federation Argentina de Fotografia
 *
 * related to Country
 * related to FederationSection
 * related to FederationMore
 * related to userContactMore
 * related to UserRole
 *
 * 2025-08-27 add contact country_id
 * 2025-08-27 add contact field
 * 2025-09-20 add 4 char to code
 * 2025-09-30 add getter function
 * 2025-10-16 table changes - v.2
 *            old 'code' field become id, string
 * Relationship 1:1 country_id
 * 2026-01-21 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property string $id UPPER, when code are equals add :country_id to both
 * @property string $country_id fk countries.id
 * @property string $name_en official name in english
 * @property string $website official website or fb info page
 * @property string $local_lang follow iso-3166 2 ascii lowercase
 * @property string $name_local when differ from official english
 * @property string $timezone_id HQ address
 * @property string $contact_info HQ address, email, and other infos
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestPatronages> $contestPatronages
 * @property-read int|null $contest_patronages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contests
 * @property-read int|null $contests_count
 * @property-read \App\Models\Country|null $country
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FederationMore> $moreFedFields
 * @property-read int|null $more_fed_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContactMore> $moreUserFields
 * @property-read int|null $more_user_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWorkMore> $moreWorkFields
 * @property-read int|null $more_work_fields_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\FederationSection> $sections
 * @property-read int|null $sections_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserRole> $userRoles
 * @property-read int|null $user_roles_count
 * @method static \Database\Factories\FederationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereContactInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereLocalLang($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereNameEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereNameLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereTimezoneId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Federation withoutTrashed()
 * @mixin \Eloquent
 */
class Federation extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'federations';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // char(10) uppercase
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //            pk char(10)
        'country_id', //    fk countries.id
        'name_en', //       english
        'local_lang', //    TODO future use for RTL
        'name_local', //    based on local_lang
        'timezone_id', //   fk timezones.id
        'website', //       official
        'contact_info', //  text address, tel etc
        // created_at       reserved
        // updated_at       reserved
        // deleted_at       reserved
    ];

    protected function casts(): array
    {
        return [
            'id' => 'string',
            'country_id' => 'string',
            'name_en' => 'string',
            'local_lang' => 'string',
            'name_local' => 'string',
            'timezone_id' => 'string',
            'website' => 'string',
            'contact_info' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // was : listed_by_country_id_name
    public static function countryIdSorted()
    {
        $federationSet = self::select()
            ->orderBy('country_id', 'asc')
            ->orderBy('name_en', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        // log
        return $federationSet;
    }

    // RELATIONSHIPS

    // federations.country_id > countries.id
    public function country(): BelongsTo
    {
        $country = $this->belongsTo(Country::class);
        // log
        return $country;
    }

    // federations.id > federation_sections.federation_id
    public function sections(): HasMany
    {
        $federationSectionsSet = $this->hasMany(FederationSection::class, 'federation_id', 'id');
        // log
        return $federationSectionsSet;
    }

    // federations.id > federation_mores.federation_id
    public function moreFedFields(): HasMany
    {
        $moreFields = $this->hasMany(FederationMore::class, 'federation_id', 'id');
        // log
        return $moreFields;
    }

    // federations.id > user_contact_mores.federation_id
    public function moreUserFields(): HasMany
    {
        $moreFields = $this->hasMany(
            related: UserContactMore::class,
            foreignKey: 'federation_id',
            localKey: 'id'
        );
        // log
        return $moreFields;
    }

    // federations.id > user_role.federation_id
    public function userRoles(): HasMany
    {
        $userRoles = $this->hasMany(
            related: UserRole::class,
            foreignKey: 'federation_id',
            localKey: 'id'
        );
        // log
        return $userRoles;
    }

    // federations.id > user_work_mores.federation_id
    public function moreWorkFields(): HasMany
    {
        $moreFields = $this->hasMany(
            related: UserWorkMore::class,
            foreignKey: 'federation_id',
            localKey: 'id'
        );
        // log
        return $moreFields;
    }

    // federations.id > contest_patronages.federation_id
    public function contestPatronages(): HasMany
    {
        $contestPatronagedSet = $this->hasMany(ContestPatronages::class);
        // Log
        return $contestPatronagedSet;
    }

    // federations.id > contest_patronages.federation_id > contest_patronages.contest_id > contests.id
    public function contests(): BelongsToMany
    {
        $contestsSet = $this->belongsToMany(
            related: Contest::class,
            table: 'contest_patronages',
            foreignPivotKey: 'federation_id',
            relatedPivotKey: 'contest_id'
        )
            ->withPivot('patronage_code')
            ->withTimestamps();
        // Log
        return $contestsSet;
    }

    public function activeContest(): BelongsToMany
    {
        $today = now()->startOfDay(); // mezzanotte UTC
        $activeContestSet = $this->contests()
            ->whereDate('day_1_opening', '<=', $today)
            ->whereDate('day_8_closing', '>=', $today);
        // Log
        return $activeContestSet;
    }
}
