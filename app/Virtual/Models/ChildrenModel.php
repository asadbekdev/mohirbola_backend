<?php

namespace App\Virtual\Models;

/**
 * @OA\Schema(
 *     title="Children",
 *     description="Children model",
 *     @OA\Xml(
 *         name="ChildrenModel"
 *     )
 * )
 */
class ChildrenModel
{
    /**
     * @OA\Property(
     *     title="id",
     *     description="id",
     *     format="int32",
     *     example="1"
     * )
     * @var int
     */
    public int $id;

    /**
     * @OA\Property(
     *     title="name",
     *     description="name",
     *     format="string",
     *     example="Nematjon"
     * )
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="birthdate",
     *     description="birthdate",
     *     format="date",
     *     example="2022-01-01"
     * )
     * @var string
     */
    public string $birthdate;

    /**
     * @OA\Property(
     *     title="grade",
     *     description="grade",
     *     format="string",
     *     example="7-sinf"
     * )
     * @var string
     */
    public string $grade;

    /**
     * @OA\Property(
     *     title="whois",
     *     description="whois",
     *     format="string",
     *     example="Dadasi"
     * )
     * @var string
     */
    public string $whois;

    /**
     * @OA\Property(
     *     title="image",
     *     description="image url",
     *     format="string",
     *     example="https://mohir-kids.uz/blank.png"
     * )
     * @var string
     */
    public string $image;

    /**
     * @OA\Property(
     *     title="code",
     *     description="code",
     *     format="int64",
     *     example="abrorakmalov#1275"
     * )
     * @var int
     */
    public int $code;

    /**
     * @OA\Property(
     *     title="password",
     *     description="password",
     *     format="int64",
     *     example="123456"
     * )
     * @var int
     */
    public int $password;
}
