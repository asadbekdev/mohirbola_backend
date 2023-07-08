<?php

namespace App\DTO;

use Spatie\LaravelData\Data;

class ResponseDTO extends Data
{
    public function __construct(
        public int $statusCode,
        public string $message
    )
    {

    }

    public function invalidParameters()
    {
        $this->setStatusCode(400);
        $this->setMessage('Invalid parameters');
    }

    public function codeNotFound()
    {
        $this->setStatusCode(404);
        $this->setMessage('Kod yoki telefon raqam noto`g`ri terilgan');
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message): void
    {
        $this->message = $message;
    }
}
