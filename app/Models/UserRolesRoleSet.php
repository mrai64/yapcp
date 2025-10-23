<?php
/**
 * auxiliary table to manage limited vocabulary set for
 * user_roles.role 
 * 
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class UserRolesRoleSet extends Model
{
    //
    public static function valid_roles() : array
    {
        Log::info( 'Model '.__CLASS__.' f/'.__FUNCTION__ .':'. __LINE__ . ' called' );
        $all_roles = self::all();
        $return_array = [];
        foreach($all_roles as $role) {
            $return_array[] = $role->role;
        }
        return $return_array;
    }
}
