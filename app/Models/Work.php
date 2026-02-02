<?php

/**
 * Works are the works, the photos, that users upload and use for
 * contests.
 * TODO refactor as UserWork
 *
 * 2026-01-22 PSR-12
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

/**
 * @property string $id uuid
 * @property string $user_id fk: users.id
 * @property string $work_file path n file
 * @property string $extension lowercase
 * @property string $reference_year default maybe YEAR(CURDATE())
 * @property string $title_en english title
 * @property string $title_local lang title
 * @property int $long_side pixel / cm
 * @property int $short_side pixel / cm
 * @property string $monochromatic not bool but oldstyle uppercase | Y / N
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\UserContact|null $userContact
 * @method static \Database\Factories\WorkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereExtension($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereLongSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereMonochromatic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereReferenceYear($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereShortSide($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereTitleLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work whereWorkFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Work withoutTrashed()
 * @mixin \Eloquent
 */
class Work extends Model
{
    /** @use HasFactory<\Database\Factories\WorkFactory> */
    use HasFactory;
    use SoftDeletes;

    public const TABLENAME = 'works';

    // primary key
    protected $primaryKey = 'id'; //  default but
    protected $keyType = 'string'; // uuid char(36)
    public $incrementing = false; //  with no increment

    protected $fillable = [
        'id', //            pk
        'user_id', //       fk user_contacts.user_id, users.id
        'work_file', //     path+filename+extension
        'extension', //     extension
        'reference_year',// a FIAF requirements
        'title_en', //      photo title
        'title_local', //   same in lang <> 'en'
        'long_side', //     file side pixel
        'short_side', //    file side pixel
        'monochromatic', // 'N' (colour) / 'Y' (monochromathic)
        // TODO instead insert a raw related flag, use work_raws
        // created_at       reserved
        // updated_at       reserved
        // deleted_at       reserved
    ];

    // to check file extension
    // was: valid_extensions
    public const VALIDEXT = [
        'jpeg',
        'jpg',
        'tiff', // future use
        'tif', //  future use
        'avif', // future use
        'jfif', // future use
        'webp', // future use
    ];

    // generate id when uuid
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = Str::uuid7();
        });
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    /**
     * add '300px_' as prefix to works.work_file
     */
    public function miniature(): string
    {
        $lastSlash = strrpos($this->work_file, '/');
        $miniature = substr($this->work_file, 0, $lastSlash).'/300px_'.substr($this->work_file, $lastSlash + 1, 50);
        // log
        return $miniature;
    }

    // RELATIONSHIP

    // works.user_id > user_contacts.user_id
    // was: user_contact
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
}
