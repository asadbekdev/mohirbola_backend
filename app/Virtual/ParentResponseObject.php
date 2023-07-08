<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="ParentResponse",
 *     description="Parent response",
 *     @OA\Xml(
 *         name="ParentResponseObject",
 *     )
 * )
 */
class ParentResponseObject
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
     *      example="Sms successfully sent",
     * )
     *
     * @var string
     */
    public string $message;
}
