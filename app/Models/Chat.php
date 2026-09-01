<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasUuids;

    protected $table = 'chats';

    protected $fillable = [
        'user_id',
        'prospect_id',
        'sender',
        'message',
        'is_read',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_read'    => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
