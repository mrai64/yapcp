<?php
/**
 * Works, but should be named UserWorks
 * TODO refactor as UserWork
 * 
 * - id //        uuid
 * - user_id //   fk users & user_contacts
 * - work_file // path and namefile
 * - extension
 * - reference_year
 * - title_en
 * - title_local
 * - long_side
 * - short_side
 * - monochromatic
 * - created_at
 * - updated_at
 * - deleted_at
 * 
 * TODO missing field for: raw_required / raw_present
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User; // users.id and 
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str; // uuid booted()

class Work extends Model
{
    /** @use HasFactory<\Database\Factories\WorkFactory> */
    use HasFactory, SoftDeletes;

    public const table_name = 'works';
    protected $keyType = 'string'; // pk uuid
    public $incrementing = false;

    protected $fillable = [
        // id
        'user_id',
        'work_file',
        'extension',
        'reference_year',
        'title_en',
        'title_local',
        'long_side',
        'short_side',
        'monochromatic',
        // TODO raw_?
        // created_at
        // updated_at
        // deleted_at
    ];

    // to check file extension 
    public const valid_extensions = [
        'jpeg',
        'jpg',
        'tiff',
        'tif',
        'avif',
        'jfif',
    ];

    // generate id when uuid
    public static function booted()
    {
        static::creating(function ($model){
            $model->id = Str::uuid7();
        });
    }

    protected function casts(): array
    {
        // Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER 

    /**
     * Miniature path+name
     * img name miniature 300px_name
     * 
     */
    public function miniature() : string
    {
        Log::info('Model '. __CLASS__ .' f/'.__FUNCTION__.':'.__LINE__.' called');
        $last_slash = strrpos($this->work_file, '/');
        return substr($this->work_file, 0, $last_slash).'/300px_'.substr($this->work_file, $last_slash+1, 50);
    }

    // RELATIONSHIP

    /**
     * $work->user_contact
     * @return UserContact works.user_id 1:1 user_contacts.user_id
     */
    public function user_contact()
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        $user_contact = $this->belongsTo(UserContact::class, 'user_id',     'user_id');
        // . . . . . . . . . . . . . . . . . . .user_contacts.user_id  works.user_id
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' user_contact:' . json_encode($user_contact) );
        return $user_contact;
    }
}
