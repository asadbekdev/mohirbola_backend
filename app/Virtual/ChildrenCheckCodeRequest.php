<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Check children code",
 *     description="Check children code",
 *     type="object",
 *     required={"code"}
 * )
 */
class ChildrenCheckCodeRequest
{
    /**
     * @OA\Property(
     *     title="code",
     *     description="children code",
     *     format="string",
     *     example="1234123412341234"
     * )
     * @var string
     */
    public string $code;
}
