<?php

namespace App\Helper;

class TelegramNotification
{
    public static function send($message): void
    {
        $chatID = -1001653309527;
        $token = '5350877144:AAFVaH1kMj1Sxl_oCvSOfInyJ4-Uuaq9DQc';

        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
        $url = $url . "&text=" . urlencode($message);
        $ch = curl_init();
        $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        curl_exec($ch);
        curl_close($ch);
    }
}
