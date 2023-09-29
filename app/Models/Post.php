<?php

namespace App\Models;

use App\Models\Scopes\PostImageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    const STATUS_DRAFT = 'draft';
    const STATUS_UNPUBLISHED = 'unpublished';
    const STATUS_PUBLISHED = 'published';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id', 'user_id', 'title', 'content', 
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function images() {
        return $this->hasMany('App\Models\Image', 'image_link_id', 'id');
    }

    // protected static function booted()
    // {
    //     static::addGlobalScope(new PostImageScope);
    // }
}
