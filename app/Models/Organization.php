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
    use HasFactory, SoftDeletes;

    //id is uuid
    protected $keyType = 'string';//     uuid string(36)
    public    $incrementing = false;//   uuid don't need ++

    protected $fillable = [
        'country_code',
        'name',
        'email',
        'website',
        'contact',
    ];

    /**
     * uuid 
     */
    public static function booted() {
        static::creating(function ($model) {
            $model->id = Str::uuid(); // uuid generator
        });
    }

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
     *   - country_code
     *   - name
     *   - data di creazione (in caso di doppie, ma poteva essere id)
     * evitando i record cancellati
     */
    public static function ListedByCountryCodeName(){

        $organizations = DB::table('organizations')
            ->select('id', 'country_code', 'name', 'email', 'website')
            ->whereNull('deleted_at')
            ->orderBy('country_code','asc')
            ->orderBy('name','asc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return $organizations;
    }
}
