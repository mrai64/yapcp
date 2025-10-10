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
        Log::info( __CLASS__.' '.__FUNCTION__ .':'. __LINE__ . ' called' );
        $all_values = self::all();
        $return_array = [];
        foreach($all_values as $status) {
            $return_array[] = $status->status;
        }
        return $return_array;
    }
}
