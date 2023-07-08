<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $children_id
 * @property int $quiz_id
 * @property int $result
 */
class QuizResult extends Model
{
    protected $table = 'quiz_results';

    protected $fillable = [
        'children_id',
        'quiz_id',
        'result'
    ];
}
