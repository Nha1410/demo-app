<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FriendRequest extends Model
{
    use HasFactory;

    public const SENDING_STATUS = 0;
    public const ACCEPTED_STATUS = 1;
    public const DECLINED_STATUS = 2;
    public const STATUS = [
        self::SENDING_STATUS => 'pending',
        self::ACCEPTED_STATUS => 'accepted',
        self::DECLINED_STATUS => 'declined',
    ];

    protected $fillable = [
        'sender_id', 'receiver_id', 'status'
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function getStatusTextAttribute()
    {
        return static::STATUS[$this->status] ?? static::SENDING_STATUS;
    }
}
