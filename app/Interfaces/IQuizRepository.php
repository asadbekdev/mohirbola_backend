<?php

namespace App\Interfaces;

interface IQuizRepository
{
    public function getActiveQuizzes();

    public function getById(int $id);

    public function search(string $query);
}
