<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\QuizModel;

/**
 * @OA\Schema(
 *     title="QuizzesResource",
 *     description="Quizzes resource",
 *     @OA\Xml(
 *         name="QuizzesResource"
 *     )
 * )
 */
class QuizzesResource
{
    /**
     * @OA\Property(
     *     title="quizzes",
     *     description="Quizzes wrapper"
     * )
     *
     * @var QuizModel $quizzes[]
     */
    private QuizModel $quizzes;
}
