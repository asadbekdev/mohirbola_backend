<?php

namespace App\Interfaces;

interface IParentsRepository
{
    public function getParentByPhone(string $phone);

    public function create(array $data);

    public function update(int $id, array $data);

    public function setIsFree(int $id, bool $isFree);
}
