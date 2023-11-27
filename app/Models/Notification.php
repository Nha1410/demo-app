<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'target_type',
        'target_id',
        'notification_type_id',
        'recipient_id',
        'content',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'recipient_id' );
    }

    public function type()
    {
        return $this->hasOne(NotificationType::class);
    }

    public function actor()
    {
        return $this->hasOne(NotificationActor::class);
    }

}
