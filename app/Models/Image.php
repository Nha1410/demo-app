<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'image_link_type',
        'path',
    ];

    protected $appends = [
        'image_path',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }


    public function getImagePathAttribute()
    {
        return Storage::url($this->path);
    }

}
