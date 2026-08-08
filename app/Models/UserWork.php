<?php

namespace App\Models;

use App\Observers\UserWorkObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;


/**
 * @property string $id
 * @property string $user_id
 * @property string $title_en english title
 * @property string $title_local user_contacts.local_lang title
 * @property string $file_path path n complete filename, complete
 * @property string $file_format file extension lowercase
 * @property int $file_size Bytes
 * @property int $file_width pixels
 * @property int $file_height pixels
 * @property int $long_size pixels
 * @property int $short_size pixels
 * @property bool $is_landscape is width >= height
 * @property bool $is_monochromatic declared BW / monochromatic
 * @property bool $has_raw_file author has raw file, of work
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @property-read \App\Models\UserContact|null $userContact
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserWorkMore> $userWorkMore
 * @property-read int|null $user_work_more_count
 * @method static \Database\Factories\UserWorkFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereFileFormat($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereFileHeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereFilePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereFileSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereFileWidth($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereHasRawFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereIsLandscape($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereIsMonochromatic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereLongSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereShortSize($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereTitleEn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereTitleLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWork withoutTrashed()
 * @mixin \Eloquent
 */

#[ObservedBy([UserWorkObserver::class])]
class UserWork extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'user_works';
    public const VALIDEXT = [
        'jpeg',
        'jpg',
        'tiff', // future use
        'tif', //  future use
        'avif', // future use
        'jfif', // future use
        'webp', // future use
    ];

    protected $fillable = [
        'id', //               pk uuid
        'user_id', //          fk users.id
        'file_path', //        path+filename+extension
        'file_format', //      file extension
        'title_en', //         photo title
        'title_local', //      same in lang <> 'en'
        'file_size', //        Byte
        'width', //            pixel
        'height', //           pixel
        'long_size', //        file side pixel
        'long_size', //        file side pixel
        'short_size', //       file side pixel
        'is_landscape', //     true/false
        'is_monochromatic', // true/false
        'has_raw_file', //     true/false
        // created_at        reserved
        // updated_at        reserved
        // deleted_at        reserved
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
            'id' => 'string',
            'user_id' => 'string',

            'title_en' => 'string',
            'title_local' => 'string',

            'file_path' => 'string',
            'file_format' => 'string',
            'file_size' => 'integer',
            'width' => 'integer',
            'height' => 'integer',
            'long_size' => 'integer',
            'short_size' => 'integer',
            'is_landscape' => 'boolean',
            'is_monochromatic' => 'boolean',
            'has_raw_file' => 'boolean',

            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER

    /**
     * Get miniature name from file_path
     */
    public function miniature(): string
    {
        $lastSlash = strrpos($this->file_path, '/');
        $miniature = substr($this->file_path, 0, $lastSlash)
            . '/300_' . substr($this->file_path, $lastSlash + 1, 50);
        // log
        return $miniature;
    }

    // warn: photobox is based on user_contacts.country_id, user_contacts.last_name,
    //       user_contacts.first_name, so check userContact->photoBox()

    // RELATIONSHIP

    // user_works.user_id > users.id > user_contacts.id ?
    // build and use shortcode:
    // user_works.user_id > user_contacts.id
    // was: user_contact
    public function user()
    {
        $user = $this->belongsTo(
            User::class,
            'user_id', //     user_works.user_id
            'id' //           users.id
        );
        // log
        return $user;
    }
    // user_works.user_id > users.id > user_contacts.id ?
    // build and use shortcode:
    // user_works.user_id > user_contacts.id
    // was: user_contact
    public function userContact()
    {
        $userContact = $this->belongsTo(
            UserContact::class,
            'user_id', //     uw.user_id
            'id' //           uc.id
        );
        // log
        return $userContact;
    }

    public function user(): BelongsTo
    {
        $user = $this->belongsTo(
            User::class,
            'user_id', //     user_works.user_id
            'id' //           user.id
        );
        // log
        return $user;
    }

    // user_works.id > user_work_mores.user_work_id
    public function userWorkMore(): HasMany
    {
        $userWorksMoreSet = $this->hasMany(
            related: UserWorkMore::class,  //  ext class
            foreignKey: 'user_work_id', //     ext user_work_mores.user_id
            localKey: 'id' //                  pk user_works.id
        );
        // log
        return $userWorksMoreSet;
    }
}
