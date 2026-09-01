<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasUuids;

    protected $table = 'chats';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_uuid',
        'suspect_uuid',
        'email',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
