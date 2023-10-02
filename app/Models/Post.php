<?php

namespace App\Models;

use App\Models\Scopes\PostImageScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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

    /**
     *   //when use global scope
     *   protected static function booted()
     *   {
     *      static::addGlobalScope(new PostImageScope);
     *   }
     */

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function images(): HasMany
    {
        return $this->hasMany('App\Models\Image', 'image_link_id', 'id');
    }

}
