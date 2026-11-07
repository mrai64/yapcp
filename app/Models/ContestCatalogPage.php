<?php

/**
 * Contest Catalog Page index
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $contest_id fk: contests.id
 * @property string|null $contest_section_id fk: contest_sections.id
 * @property string|null $contest_work_id fk: contest_works.id
 * @property string|null $contest_award_id fk: contest_awards.id
 * @property int $page
 * @property string $layout_type fk: contest_catalog_pages_layout_sets.layout_type
 * @property string|null $country_id fk: countries.id
 * @property string|null $author_name
 * @property string|null $title
 * @property string|null $subtitle
 * @property string|null $image_path
 * @property string|null $description
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Contest|null $contest
 * @property-read \App\Models\ContestAward|null $contestAward
 * @property-read \App\Models\ContestSection|null $contestSection
 * @property-read \App\Models\ContestWork|null $contestWork
 * @property-read \App\Models\Country|null $country
 * @property-read \App\Models\ContestCatalogPagesLayoutSet|null $layoutType
 * @method static \Database\Factories\ContestCatalogPageFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereAuthorName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereContestAwardId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereContestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereContestSectionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereContestWorkId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereCountryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereImagePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereLayoutType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage wherePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereSubtitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPage withoutTrashed()
 * @mixin \Eloquent
 */
class ContestCatalogPage extends Model
{
    /** @use HasFactory<\Database\Factories\ContestCatalogPageFactory> */
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'contest_catalog_pages';

    // no uuid pk - standard id bigint autoincrement
    protected $fillable = [
        'id', //                   standard id bigint unsigned autoincrement
        'contest_id', //           fk: contests.id
        'contest_section_id', //   nullable (contest) | fk: contest_sections.id
        'contest_work_id', //      nullable | fk: contest_works.id
        'contest_award_id', //     nullable | fk:contest_awards.id
        'page', //                 unsigned int, contest_id + page must be unique
        'layout_type', //          fk: contest_catalog_pages_layout_sets.layout_page - lookup table
        //
        'country_id', //           fk: countries.id, also user_contacts.country_id
        'author_name', //          user_contacts.first_name, user_contacts.last_name
        'title',
        'subtitle',
        'image_path', //          for image out of contest_works.id, i.e. federation sponsor marks
        'description', //         for citation and other free text
        // created_at          reserved
        // updated_at          reserved
        // deleted_at          reserved
    ];
    //
    protected function casts()
    {
        return [
            'id'                 => 'int',
            'contest_id'         => 'string',
            'contest_section_id' => 'string',
            'contest_work_id'    => 'string',
            'contest_award_id'   => 'string',
            'page'               => 'int',
            'layout_type'        => 'string',
            'country_id'         => 'string',
            'author_name'        => 'string',
            'title'              => 'string',
            'subtitle'           => 'string',
            'image_path'         => 'string',
            'description'        => 'string',
            'created_at'         => 'datetime',
            'updated_at'         => 'datetime',
            'deleted_at'         => 'datetime',
        ];
    }

    // RELATIONS
    // contest_catalog_pages.contest_id > contests.id
    public function contest(): BelongsTo
    {
        return $this->belongsTo(Contest::class);
    }
    // contest_catalog_pages.contest_section_id > contest_sections.id
    public function contestSection(): BelongsTo
    {
        return $this->belongsTo(ContestSection::class);
    }
    // contest_catalog_pages.contest_work_id > contest_works.id
    public function contestWork(): BelongsTo
    {
        return $this->belongsTo(ContestWork::class);
    }
    // contest_catalog_pages.contest_award_id > contest_awards.id
    public function contestAward(): BelongsTo
    {
        return $this->belongsTo(ContestAward::class);
    }
    // contest_catalog_pages.country_id > countries.id
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }
    // to pick file path
    public function layoutType(): BelongsTo
    {
        return $this->belongsTo(ContestCatalogPagesLayoutSet::class, 'layout_type', 'layout_type');
    }
}
