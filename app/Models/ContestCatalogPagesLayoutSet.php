<?php

/**
 * Lookup table for contest_catalog_pages.layout_page
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $layout_type
 * @property string $template_file_path path n complete filename, complete
 * @property string $title_en english page definition
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ContestCatalogPage> $contestCatalogPage
 * @property-read int|null $contest_catalog_page_count
 * @method static \Database\Factories\ContestCatalogPagesLayoutSetFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereLayoutType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereTemplateFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContestCatalogPagesLayoutSet withoutTrashed()
 * @mixin \Eloquent
 */
class ContestCatalogPagesLayoutSet extends Model
{
    /** @use HasFactory<\Database\Factories\ContestCatalogPagesLayoutSetFactory> */
    use HasFactory;
    use SoftDeletes;

    //
    protected $primaryKey = 'layout_page'; // default 'id'
    protected $keyType = 'string'; //         char(16)
    public $incrementing = false; //          no autoincrement
    //
    protected $fillable = [
        'id',
        'template_file_path',
        'title_en',
        // created_at
        // updated_at
        // deleted_at
    ];
    //
    protected function casts()
    {
        return [
            'layout_type' => 'string',
            'template_file_path' => 'string',
            'title_en' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // RELATIONSHIP

    public function contestCatalogPage(): HasMany
    {
        return $this->hasMany(ContestCatalogPage::class, 'layout_page', 'id');
    }
}
