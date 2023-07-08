<?php

namespace App\Service;

use App\Helper\TelegramNotification;
use App\Models\SmsToken;
use Exception;

class SmsService
{
    /**
     * @throws Exception
     */
    public function sendSms(string $phone): void
    {
        $this->deleteOldCodes($phone);
        $code = $this->generateCode();
        $token = [
            'phone' => $phone,
            'code' => $code,
            'is_sent' => true
        ];
        $this->saveToken($token);
        TelegramNotification::send("Phone: $phone, Code: $code");
    }

    public function deleteOldCodes(string $phone): void
    {
        SmsToken::query()->where('phone', $phone)->delete();
    }

    /**
     * @param array $data
     * @return void
     */
    private function saveToken(array $data): void
    {
        SmsToken::query()->updateOrCreate($data);
    }

    /**
     * @throws Exception
     */
    private function generateCode(): int
    {
        return random_int(100000, 999999);
    }
}
