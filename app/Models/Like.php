<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory, SoftDeletes;

    public const LIKE_EMOTION = 1;
    public const LOVE_EMOTION = 2;
    public const HAHA_EMOTION = 3;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'likeable_id',
        'likeable_type',
        'emoji_type',
    ];

    public function likeable()
    {
        return $this->morphTo();
    }
}
