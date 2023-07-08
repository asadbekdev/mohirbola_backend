<?php

namespace App\Interfaces;

interface ISmsTokenRepository
{
    public function getSmsTokenByPhoneAndCode(string $phone, string $code);
}
