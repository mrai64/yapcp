<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserRoleRoleSet extends Model
{
    /** @use HasFactory<\Database\Factories\UserRoleRoleSetFactory> */
    use HasFactory,SoftDeletes;
}
