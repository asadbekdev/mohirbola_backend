<?php

namespace App\Helper;

use Illuminate\Support\Facades\Http;
use JsonException;

/**
 * Class Slack
 * @package App\Helper
 */
class Slack
{
    private const hookUrl = "https://hooks.slack.com/services/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";

    /**
     * @param $data
     * @return void
     */
    public static function debug($data): void
    {
        $info = debug_backtrace();
        $file = "File: {$info[0]['file']} Line: {$info[0]['line']}";
        $text = is_array($data) ? json_encode($data) : $data;
        $text .= PHP_EOL . $file;
        Http::withHeaders([
            'Content-type' => 'application/json'
        ])->post(self::hookUrl, [
            'text' => $text,
        ]);
    }


    /**
     * @throws JsonException
     */
    public static function send($data, string $channel = 'debug'): bool
    {
        $info = debug_backtrace();
        $integrationUrl = self::hookUrl;
        $rawData = 'HM:' . (is_string($data) ? $data : print_r($data, true)) . "\n";
        $rawData .= "File: {$info[0]['file']} Line: {$info[0]['line']}\n";
        $rawData .= "\r";

        $message = json_encode($rawData, JSON_THROW_ON_ERROR);
        $cmd = <<<MYCODE
curl -X POST --data-urlencode 'payload={"channel": "#$channel", "username": "o2b3k", "text": $message, "icon_url": "http://pbs.twimg.com/profile_images/3466225963/b844139b08cb9903dbd3b0b90f4d4af8_normal.png", "unfurl_links": false, "unfurl_media": false}' $integrationUrl > /dev/null 2>&1 &
MYCODE;

        exec($cmd, $output, $exit);
        return $exit === 0;
    }
}
