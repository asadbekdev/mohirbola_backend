<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $time
 * @property int $children_id
 * @property string $created_at
 */
class DailyUsage extends Model
{
    protected $table = 'daily_usages';

    protected $fillable = [
        'usage',
        'children_id',
        'created_at'
    ];
}
