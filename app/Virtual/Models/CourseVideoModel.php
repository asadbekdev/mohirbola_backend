<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="CourseVideos",
 *     description="Course video model",
 *     @OA\Xml(
 *         name="CourseVideoModel"
 *     )
 * )
 */
class CourseVideoModel
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
     *     title="title",
     *     description="Course title",
     *     format="string",
     *     example="Sanashni organamiz 1-qism"
     * )
     * @var string
     */
    public string $title;

    /**
     * @OA\Property(
     *     title="video",
     *     description="Course video",
     *     format="string",
     *     example="https://vimeo.com/joaopombeiro/chicago"
     * )
     * https://player.vimeo.com/video/696218740?h=54fadb098d
     * @var string
     */
    public string $video;

    /**
     * @OA\Property(
     *     title="video",
     *     description="Course video",
     *     format="string",
     *     example="https://player.vimeo.com/video/696218740?h=54fadb098d"
     * )
     * @var string
     */
    public string $video_url;

    /**
     * @OA\Property(
     *     title="info",
     *     description="Video description",
     *     format="string",
     *     example="Sanashni organamiz 1-qism"
     * )
     * @var string
     */
    public string $info;
}
