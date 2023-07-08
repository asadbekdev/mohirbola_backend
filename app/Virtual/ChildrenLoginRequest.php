<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Children login request",
 *     description="Children login request body",
 *     type="object",
 *     required={"code","password"}
 * )
 */
class ChildrenLoginRequest
{
    /**
     * @OA\Property(
     *     title="code",
     *     description="Children code",
     *     format="int32",
     *     example="1234123412341234"
     * )
     * @var string
     */
    public string $code;

    /**
     * @OA\Property(
     *     title="password",
     *     description="Children password",
     *     format="int32",
     *     example="123123"
     * )
     * @var string
     */
    public string $password;
}
