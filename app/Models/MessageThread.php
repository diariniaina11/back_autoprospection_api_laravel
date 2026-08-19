<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class MessageThread extends Model
{
    use HasUuids;

    protected $table = 'message_threads';

    public $timestamps = false;

    protected $fillable = [
        'reply_id',
        'sender',
        'text',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
