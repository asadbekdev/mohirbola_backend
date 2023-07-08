<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Parent access token response",
 *     description="Parent access token response",
 *     type="object",
 *     required={"name", "phone"}
 * )
 */
class ParentAccessTokenResponse
{
    /**
     * @OA\Property(
     *     title="access token",
     *     description="Access token",
     *     example=""
     * )
     * @var string
     */
    public string $access_token;

    /**
     * @OA\Property(
     *     title="token type",
     *     description="Access token type",
     *     example="bearer"
     * )
     * @var string
     */
    public string $token_type;

    /**
     * @OA\Property(
     *     title="expires time",
     *     description="Expires access token time",
     *     example="86400"
     * )
     * @var string
     */
    public string $expires_in;
}
