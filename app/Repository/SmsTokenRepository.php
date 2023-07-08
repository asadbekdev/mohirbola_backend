<?php

namespace App\Repository;

use App\Interfaces\ISmsTokenRepository;
use App\Models\SmsToken;

class SmsTokenRepository implements ISmsTokenRepository
{
    public function getSmsTokenByPhoneAndCode(string $phone, string $code): object|null
    {
        return SmsToken::query()->where('phone', $phone)->where('code', $code)->first();
    }
}
