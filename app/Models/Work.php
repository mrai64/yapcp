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
