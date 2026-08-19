<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    protected $table = 'test';

    const UPDATED_AT = null;

    protected $fillable = [
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
