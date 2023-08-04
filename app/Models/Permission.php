<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as Model;
use Spatie\Permission\Contracts\Permission as PermissionContract;

class Permission extends Model
{
    public $timestamps = false;
}
