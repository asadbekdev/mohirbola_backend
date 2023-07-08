<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Algorithm extends Model
{
    protected $table = 'algorithms';

    protected $fillable = [
        'id',
        'title',
        'image',
        'level',
        'description',
        'is_active',
        'is_paid',
    ];
}
