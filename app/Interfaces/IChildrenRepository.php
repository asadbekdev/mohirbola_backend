<?php

namespace App\Interfaces;

interface IChildrenRepository
{
    public function find(int $id);

    public function checkCode(string $code);

    public function login(string $code, int $password);

    public function create(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
