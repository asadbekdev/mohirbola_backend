<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Check sms token request",
 *     description="Check sms token request body",
 *     type="object",
 *     required={"phone", "code"}
 * )
 */
class CheckSmsTokenRequest
{
    /**
     * @OA\Property(
     *     title="phone",
     *     description="Parent phone number",
     *     example="+998950330455"
     * )
     * @var string
     */
    public string $phone;

    /**
     * @OA\Property(
     *     title="code",
     *     description="Code from sms",
     *     example="123456"
     * )
     * @var string
     */
    public string $code;
}
