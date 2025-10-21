<?php
/**
 * Works, should be named UserWorks
 * child table for: UserContact 1:N
 * grandchild  for: User
 * 
 * 
 * pk is uuid
 * - id
 * - user_id // users & user_contacts
 * - work_file
 * - extension
 * - reference_year
 * - title_en
 * - title_local
 * - long_side
 * - short_side
 * _ monochromatic
 * - created_at
 * - updated_at
 * - deleted_at
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
    
    public const valid_extensions = [
        'jpg',
        'jpeg',
        'webp',
    ];
    protected $fillable = [
        'user_id',
        'work_file',
        'extension',
        'reference_year',
        'title_en',
        'title_local',
        'long_side',
        'short_side',
        'monochromatic',
    ];

    public User $owner;

    // uuid as pk 
    protected $keyType = 'string';
    public $incrementing = false;
    public static function booted()
    {
        static::creating(function ($model){
            $model->id = Str::uuid();
        });
    }

    protected function casts(): array
    {
        Log::info('Model ' . __CLASS__ .' f/'. __FUNCTION__.':' . __LINE__ . ' called');
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    // GETTER 

    /**
     * $works->user_contact
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
