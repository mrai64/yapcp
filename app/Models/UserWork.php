<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UserWork extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    public const TABLENAME = 'user_works';

    protected $fillable = [
        'id', //               pk uuid
        'user_id', //          fk users.id
        'file_path', //        path+filename+extension
        'file_format', //      file extension
        'title_en', //         photo title
        'title_local', //      same in lang <> 'en'
        'file_size', //        Byte
        'long_size', //        file side pixel
        'short_size', //       file side pixel
        'is_monochromatic', // true/false
        'has_raw_fiile', //    true/false
        // created_at        reserved
        // updated_at        reserved
        // deleted_at        reserved
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
            'id' => 'string',
            'user_id' => 'string',

            'title_en' => 'string',
            'title_local' => 'string',

            'file_path' => 'string',
            'file_format' => 'string',
            'file_size' => 'int',
            'long_size' => 'int',
            'short_size' => 'int',
            'is_monochromatic' => 'bool',
            'has_raw_file' => 'bool',

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
            . '/300px_' . substr($this->file_path, $lastSlash + 1, 50);
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
