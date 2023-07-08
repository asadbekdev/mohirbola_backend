<?php

namespace App\Virtual\Resources;

use App\Virtual\Models\CourseModel;

/**
 * @OA\Schema(
 *     title="CourseResource",
 *     description="Course resource",
 *     @OA\Xml(
 *         name="CourseResource"
 *     )
 * )
 */
class CourseResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var CourseModel[]
     */
    private array $data;
}
