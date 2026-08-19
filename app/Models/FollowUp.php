<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class FollowUp extends Model
{
    use HasUuids;

    protected $table = 'follow_ups';

    public $timestamps = false;

    protected $fillable = [
        'prospect_id',
        'step',
        'status',
        'template_subject',
        'template_body',
        'scheduled_at',
        'sent_at',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
    ];
}
