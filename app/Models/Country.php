<?php

/**
 * Countries w/flag
 * lookup table
 *
 * related to UserContact
 * related to Federation
 * related to Organization
 * related to Contest //      TODO unneccessary
 * related to ContestWork //  TODO unneccessary
 *
 * 2025-08-29 picked from iso.org open broad data
 * 2025-09-17 flag_code added to fillable fields
 * 2025-09-22 add getter function
 * 2025-09-29 add getter function
 * 2025-12-04 completed unicode flag manual fills
 * 2026-01-21 PSR-12
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

/**
 * @property string $id iso-3166 alpha-3 UPPERCASE
 * @property string $country en
 * @property string|null $flag_code Unicode chars for country flag emoji
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contest> $contest
 * @property-read int|null $contest_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Federation> $federation
 * @property-read int|null $federation_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Organization> $organization
 * @property-read int|null $organization_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContact> $user_contact
 * @property-read int|null $user_contact_count
 * @method static \Database\Factories\CountryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereFlagCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Country withoutTrashed()
 * @mixin \Eloquent
 */
class Country extends Model
{
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'countries';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // char(3) iso-3136 ascii-3 uppercase
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //         uppercase char(3)
        'country', //    english
        'flag_code', //  unicode 🇺🇳
        // created_at    reserved
        // updated_at    reserved
        // deleted_at    reserved
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTERS

    // was: country_list_by_country
    public static function countriesSorted()
    {
        $countries = self::select('country')->orderBy('country')->get();
        // log
        return $countries;
    }

    // was: country_name
    public static function countryName(string $country_id): string
    {
        $country = self::where('id', $country_id)->get()[0];
        // log
        return $country->country.' /'.$country->flag_code;
    }

    // was: country_flag
    public static function countryFlag(string $country_id): string
    {
        $flag = self::where('id', $country_id)->get('flag_code')[0];
        // log
        return (is_null($flag['flag_code'])) ? '🏳️' : $flag['flag_code'];
    }

    // RELATIONS

    public function contest(): BelongsToMany
    {
        $contest_set = $this->belongsToMany(Contest::class);
        // log
        return $contest_set;
    }

    public function federation(): BelongsToMany
    {
        $federation_set = $this->belongsToMany(Federation::class);
        // log
        return $federation_set;
    }

    public function organization(): BelongsToMany
    {
        $organization_set = $this->belongsToMany(Organization::class);
        // log
        return $organization_set;
    }

    public function user_contact(): BelongsToMany
    {
        $user_contact_set = $this->belongsToMany(UserContact::class);
        // log
        return $user_contact_set;
    }
}
