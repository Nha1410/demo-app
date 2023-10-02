<?php

namespace App\Models;

use Spatie\Permission\Models\Role as Model;
use Spatie\Permission\Contracts\Role as RoleContract;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'display_name',
        'guard_name',
        'created_at',
        'updated_at',
    ];

}
