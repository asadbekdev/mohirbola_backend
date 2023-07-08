<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="ChildrenResponse",
 *     description="Parent response",
 *     @OA\Xml(
 *         name="ChildrenResponseObject",
 *     )
 * )
 */
class ChildrenResponseObject
{
    /**
     * @OA\Property(
     *      title="status",
     *      description="Status code",
     *      example="201"
     * )
     *
     * @var string
     */
    public string $status;

    /**
     * @OA\Property(
     *      title="message",
     *      description="Message",
     *      example="Children found, please enter a code",
     * )
     *
     * @var string
     */
    public string $message;
}
