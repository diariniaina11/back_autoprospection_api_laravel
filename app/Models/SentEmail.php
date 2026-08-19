<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class SentEmail extends Model
{
    use HasUuids;

    protected $table = 'sent_emails';

    const UPDATED_AT = null;

    protected $fillable = [
        'campaign_id',
        'prospect_id',
        'model_id',
        'subject',
        'body',
        'status',
        'error_message',
        'sent_at',
        'created_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
