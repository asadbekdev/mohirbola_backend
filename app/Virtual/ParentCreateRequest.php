<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Parent create request",
 *     description="Parent create request body",
 *     type="object",
 *     required={"name", "phone"}
 * )
 */
class ParentCreateRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Parent name",
     *      example="Nematjon"
     * )
     *
     * @var string
     */
    public string $name;

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
