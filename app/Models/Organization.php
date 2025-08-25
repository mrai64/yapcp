<?php
/**
 * Organization | Organisation
 * They are Contest organizer
 *
 * uuid
 * hasFactory
 * softDelete
 * verifyEmail(?)
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class Organization extends Model
{
    use HasFactory, SoftDeletes ;

    //uuid
    protected $keyType = 'string';//     uuid string(36)
    public    $incrementing = false;//   uuid don't need ++
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }
    //uuid

    protected $fillable = [
        'country_code',
        'name',
        'email',
        'website',
    ];

    protected function casts()
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
        ];
    }

    /**
     * Per garantire l'ordine 
     * . country_code
     *   - name
     */
    public static function ListedByCountryCodeName(){

        $organizations = DB::table('organizations')
            ->select('id', 'country_code', 'name', 'email', 'website')
            ->orderBy('country_code','asc')
            ->orderBy('name','asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $organizations;
    }
}
