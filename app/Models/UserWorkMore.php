<?php

/**
 * Key Values added to user_works
 * depending - reserved for a federation requirements
 * as in user_contacts_mores
 *
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Database\Factories\UserWorkMoreFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserWorkMore query()
 * @mixin \Eloquent
 */
class UserWorkMore extends Model
{
    /** @use HasFactory<\Database\Factories\UserWorkMoreFactory> */
    use HasFactory;
}
