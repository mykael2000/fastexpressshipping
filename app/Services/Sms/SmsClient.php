<?php

namespace App\Services\Sms;

interface SmsClient
{
    public function isConfigured(): bool;

    /**
     * @throws \Throwable on failure
     */
    public function send(string $to, string $message): void;

    public function name(): string;
}
