<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    public const NOTIFICATION_FROM_POST = 1;
    public const NOTIFICATION_FROM_COMMENT = 2;
    public const NOTIFICATION_FROM_TAG_POST = 3;
    public const NOTIFICATION_FROM_TAG_COMMENT = 4;
    public const NOTIFICATION_FROM_FOLLOWER = 5;
    public const NOTIFICATION_MESSAGE = [
        self::NOTIFICATION_FROM_POST => 'commented on your post',
        self::NOTIFICATION_FROM_COMMENT => 'reply your comment',
        self::NOTIFICATION_FROM_TAG_POST => 'has tagged you in a post',
        self::NOTIFICATION_FROM_TAG_COMMENT => 'has tagged you in a comment',
        self::NOTIFICATION_FROM_FOLLOWER => 'posted a new article',

    ];

    protected $fillable = [
        'target_type',
        'target_id',
        'recipient_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'recipient_id' );
    }

}
