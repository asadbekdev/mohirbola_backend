<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Course",
 *     description="Course model",
 *     @OA\Xml(
 *         name="CourseModel"
 *     )
 * )
 */
class CourseModel
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
     *     description="Parent name",
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
}
