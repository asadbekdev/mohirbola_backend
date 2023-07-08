<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Question",
 *     description="Quiz question model",
 *     @OA\Xml(
 *         name="QuizQuestionModel"
 *     )
 * )
 */
class QuizQuestionModel
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     format="int64",
     *     example="1"
     * )
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(
     *     title="question",
     *     description="Question",
     *     format="string",
     *     example="Ingliz tilitda Otni nima deyiladi?"
     * )
     * @var string
     */
    public string $question;

    /**
     * @OA\Property(
     *     title="answer_1",
     *     description="Birinchi javob",
     *     format="string",
     *     example="Cow"
     * )
     * @var string
     */
    public string $answer_1;

    /**
     * @OA\Property(
     *     title="answer_2",
     *     description="Ikkinchi javob",
     *     format="string",
     *     example="Lion"
     * )
     * @var string
     */
    public string $answer_2;

    /**
     * @OA\Property(
     *     title="answer_3",
     *     description="Uchinchi javob",
     *     format="string",
     *     example="Horse"
     * )
     * @var string
     */
    public string $answer_3;

    /**
     * @OA\Property(
     *     title="answer_4",
     *     description="Tortinchi javob",
     *     format="string",
     *     example="Cat"
     * )
     * @var string
     */
    public string $answer_4;

    /**
     * @OA\Property(
     *     title="correct_answer",
     *     description="Togri javob",
     *     format="int64",
     *     example="3"
     * )
     * @var int
     */
    public int $correct_answer;

    /**
     * @OA\Property(
     *     title="quiz_id",
     *     description="Quiz id",
     *     format="int64",
     *     example="1"
     * )
     * @var int
     */
    public int $quiz_id;
}
