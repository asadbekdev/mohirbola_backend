<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Parent",
 *     description="Parent model",
 *     @OA\Xml(
 *         name="ParentModel"
 *     )
 * )
 */
class ParentModel
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
     *     title="name",
     *     description="Parent name",
     *     format="string",
     *     example="Nematjon"
     * )
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="phone",
     *     description="Parent phone number",
     *     format="string",
     *     example="+998950330455"
     * )
     * @var string
     */
    public string $phone;

    /**
     * @OA\Property(
     *     title="image",
     *     description="Image url",
     *     format="string",
     *     example="https://upload.wikimedia.org/wikipedia/commons/7/70/User_icon_BLACK-01.png"
     * )
     * @var string
     */
    public string $image;

    /**
     * @OA\Property(
     *     title="is_free",
     *     description="Free user",
     *     format="boolean",
     *     example="true"
     * )
     * @var bool
     */
    public bool $is_free;

    /**
     * @OA\Property(
     *     title="is_active",
     *     description="Active user",
     *     format="boolean",
     *     example="true"
     * )
     * @var bool
     */
    public bool $is_active;

    /**
     * @OA\Property(
     *     title="remember_token",
     *     description="Remember token",
     *     format="string",
     *     example="asdasdasfasfasd"
     * )
     * @var string|null
     */
    public ?string $remember_token;

    /**
     * @OA\Property(
     *     title="created_at",
     *     description="Created at",
     *     format="string",
     *     example="2022-04-04T10:10:10"
     * )
     *
     * @var string|null
     */
    public ?string $created_at;

    /**
     * @OA\Property(
     *     title="updated_at",
     *     description="Updated at",
     *     format="string",
     *     example="2022-04-04T10:10:10"
     * )
     *
     * @var string|null
     */
    public ?string $updated_at;
}
