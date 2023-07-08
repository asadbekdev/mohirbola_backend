<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Parent login request",
 *     description="Parent login request body",
 *     type="object",
 *     required={"phone"}
 * )
 */
class ParentLoginRequest
{
    /**
     * @OA\Property(
     *      title="phone",
     *      description="Parent phone number",
     *      example="+998950330455"
     * )
     *
     * @var string
     */
    public string $phone;
}
