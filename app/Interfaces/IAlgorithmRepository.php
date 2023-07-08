<?php

namespace App\Interfaces;

interface IAlgorithmRepository
{
    public function getAlgorithms();

    public function getById(int $id);
}
