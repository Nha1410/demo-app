<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationActor extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'notification_id',
    ];

    public function notification()
    {
        return $this->belongsTo('notification');
    }

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
