<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\QuizQuestionModel;

/**
 * @OA\Schema(
 *     title="QuizResource",
 *     description="Quiz resource",
 *     @OA\Xml(
 *         name="QuizResource"
 *     )
 * )
 */
class QuizResource
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
     *     title="name",
     *     description="Quiz name",
     *     format="string",
     *     example="Sanashni organamiz"
     * )
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="image",
     *     description="Image url",
     *     format="string",
     *     example="https://upload.wikimedia.org/wikipedia/commons/7/70/User_icon_BLACK-01.png"
     * )
     * @var string
     */
    public string $image;

    /**
     * @OA\Property(
     *     title="background",
     *     description="Background image url",
     *     format="string",
     *     example="https://upload.wikimedia.org/wikipedia/commons/7/70/User_icon_BLACK-01.png"
     * )
     * @var string
     */
    public string $background;

    /**
     * @OA\Property(
     *     title="info",
     *     description="Quiz info",
     *     format="string",
     *     example="Sanashni organamiz"
     * )
     * @var string
     */
    public string $info;

    /**
     * @OA\Property(
     *     title="is_active",
     *     description="1",
     *     format="int64",
     *     example="1"
     * )
     * @var int
     */
    public int $is_active;

    /**
     * @OA\Property(
     *     title="questions",
     *     description="Quiz questions"
     * )
     *
     * @var QuizQuestionModel $quizzes[]
     */
    public QuizQuestionModel $questions;
}
