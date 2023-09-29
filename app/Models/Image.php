<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'image_link_id',
        'image_type',
        'path',
    ];

    protected $appends = [
        'image_path',
    ];

    public function post() {
        return $this->belongsToMany('App\Models\Image', 'image_link_id', 'id');
    }

    public function getImagePathAttribute()
    {
        return Storage::url($this->path);
    }
    
}
