<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Friend extends Model
{
    use HasFactory, SoftDeletes;

    public const NORMAL_STATUS = 0;
    public const FAVORITED_STATUS = 1;
    public const BLOCKED_STATUS = 2;
    public const STATUS = [
        self::NORMAL_STATUS => 'normal',
        self::FAVORITED_STATUS => 'favorited',
        self::BLOCKED_STATUS => 'blocked',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id', 'friend_id', 'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function friend()
    {
        return $this->belongsTo(User::class, 'friend_id');
    }
}
