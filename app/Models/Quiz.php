<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $image
 * @property string $background
 * @property string $info
 * @property boolean $is_active
 * @method static active()
 */
class Quiz extends Model
{
    protected $table = 'quizzes';

    protected $fillable = [
        'id',
        'name',
        'image',
        'background',
        'info',
        'is_active',
    ];

    public $timestamps = false;

    public function questions(): HasMany
    {
        return $this->hasMany(QuizQuestion::class, 'quiz_id');
    }

    /**
     * Scope a query to only include active users.
     *
     * @param Builder $query
     * @return void
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
