<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasUuids;

    protected $table = 'replies';

    public $timestamps = false;

    protected $fillable = [
        'prospect_id',
        'sent_email_id',
        'category',
        'subject',
        'preview',
        'message',
        'received_at',
    ];

    protected $casts = [
        'received_at' => 'datetime',
    ];
}
