<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'recipient_id', 'gift_id', 'title',
        'event_date', 'type', 'notification_days', 'status'
    ];

    protected $casts = [
        'event_date' => 'date',
    ];

    public function recipient()
    {
        return $this->belongsTo(Recipient::class);
    }

    public function gift()
    {
        return $this->belongsTo(Gift::class);
    }
}
