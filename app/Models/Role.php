<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission');
    }
}
