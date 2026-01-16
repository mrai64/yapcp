<?php

/**
 * Table generate by laravel installation and
 * modified to use uuid as primary key
 * 2025-08-31 id became uuid instead of bigint unsigned autoincrement
 * 2025-09-13 Notify users login w/email
 * 2025-10-13 User n UserContact are in relationship 1:1
 *            User n UserRole    are in relationship 1:N
 *            User n (User)Work  are in relationship 1:N
 */

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable; // uuid booted()
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

// class User extends Authenticatable
class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    // used to show a version number
    public const version = '2025.12.1 dev';

    public const TABLENAME = 'users'; // MAYBE $this->table_name()

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Use uuid for primary key
     */
    protected $keyType = 'string';

    public $incrementing = false;

    public static function booted()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        static::creating(function ($model) {
            $model->id = Str::uuid7();
        });
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // GETTERS

    // RELATIONSHIPs

    /**
     * 1:1 relationship bw/users n user_contact
     * $user->contact not $user_contact()
     *
     * user_contacts.user_id match users.id
     */
    public function contact()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');

        $contact = $this->hasOne(UserContact::class); // normally
        // $contact = $this->hasOne(UserContact::class, 'user_id', 'id'); // when foreignId() and foreign key are out of standard
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' contact: '.json_encode($contact));

        return $contact;
    }

    /**
     * 1:N relationship bw/users n user_roles
     *
     * user_roles.user_id match users.id
     */
    public function roles()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $roles = $this->hasMany(UserRole::class);

        return $roles;
    }

    public function works()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $works = $this->hasMany(Work::class);

        return $works;
    }

    public function juries()
    {
        Log::info('Model '.__CLASS__.' f/'.__FUNCTION__.':'.__LINE__.' called');
        $juries = $this->hasMany(ContestJury::class, 'user_contact_id', 'id');

        return $juries;
    }
}
