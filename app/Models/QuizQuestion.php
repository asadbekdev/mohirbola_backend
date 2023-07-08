<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $question
 * @property string $answer_1
 * @property string $answer_2
 * @property string $answer_3
 * @property string $answer_4
 * @property integer $correct_answer
 * @property string $type
 */
class QuizQuestion extends Model
{
    protected $table = 'quiz_questions';

    protected $fillable = [
        'id',
        'question',
        'answer_1',
        'answer_2',
        'answer_3',
        'answer_4',
        'correct_answer',
        'type'
    ];

    public $timestamps = false;

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
