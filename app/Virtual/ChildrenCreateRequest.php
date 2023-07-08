<?php

namespace App\Virtual;

/**
 * @OA\Schema(
 *     title="Children create request",
 *     description="Children create request body",
 *     type="object",
 *     required={"name", "birthdate", "grade", "whois"}
 * )
 */
class ChildrenCreateRequest
{
    /**
     * @OA\Property(
     *     title="name",
     *     description="Ismi",
     *     format="string",
     *     example="Abror"
     * )
     * @var string
     */
    public string $name;

    /**
     * @OA\Property(
     *     title="birthdate",
     *     description="Tugilgan kuni",
     *     format="date",
     *     example="2022-03-01"
     * )
     * @var string
     */
    public string $birthdate;

    /**
     * @OA\Property(
     *     title="grade",
     *     description="Sinfi kiritish ixtiyoriy",
     *     format="string",
     *     example="7-sinf"
     * )
     * @var string
     */
    public string $grade;

    /**
     * @OA\Property(
     *     title="whois",
     *     description="Siz unga kim bolasiz",
     *     format="string",
     *     example="Dadasi"
     * )
     * @var string
     */
    public string $whois;
}
