<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasUuids;

    protected $table = 'prospects';

    const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'suspect_id',
        'category_id',
        'name',
        'company',
        'email',
        'phone',
        'source',
        'status',
        'added_at',
        'created_at',
    ];

    protected $casts = [
        'added_at' => 'datetime',
        'created_at' => 'datetime',
    ];
}
