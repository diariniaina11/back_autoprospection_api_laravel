<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Suspect extends Model
{
    use HasUuids;

    protected $table = 'suspects';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'company',
        'email',
        'source',
        'status',
        'detected_at',
        'created_at',
    ];

    protected $casts = [
        'detected_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
