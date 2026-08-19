<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasUuids;

    protected $table = 'campaigns';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'name',
        'status',
        'total_contacts',
        'sent_count',
        'failed_count',
        'created_at',
    ];

    protected $casts = [
        'total_contacts' => 'integer',
        'sent_count' => 'integer',
        'failed_count' => 'integer',
        'created_at' => 'datetime',
    ];
}
