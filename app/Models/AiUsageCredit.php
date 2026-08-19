<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AiUsageCredit extends Model
{
    use HasUuids;

    protected $table = 'ai_usage_credits';

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'credits_allocated',
        'credits_used',
        'last_reset_at',
    ];

    protected $casts = [
        'credits_allocated' => 'integer',
        'credits_used' => 'integer',
        'last_reset_at' => 'datetime',
    ];
}
