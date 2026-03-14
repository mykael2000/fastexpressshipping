<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Http;

class TermiiSmsClient implements SmsClient
{
    public function name(): string
    {
        return 'termii';
    }

    public function isConfigured(): bool
    {
        return (bool) config('services.termii.api_key')
            && (bool) config('services.termii.sender_id');
    }

    public function send(string $to, string $message): void
    {
        $baseUrl = rtrim((string) config('services.termii.base_url', 'https://api.ng.termii.com'), '/');
        $apiKey = (string) config('services.termii.api_key');
        $senderId = (string) config('services.termii.sender_id');

        // Strip leading '+' for Termii (e.g. +2348012345678 → 2348012345678)
        $to = ltrim($to, '+');

        $response = Http::asJson()
            ->timeout(15)
            ->post($baseUrl.'/api/sms/send', [
                'to' => $to,
                'from' => $senderId,
                'sms' => $message,
                'type' => 'plain',
                'channel' => 'generic',
                'api_key' => $apiKey,
            ]);

        if (! $response->successful()) {
            throw new \RuntimeException(
                "Termii HTTP {$response->status()}: ".$response->body()
            );
        }

        $json = $response->json();
        if (
            is_array($json)
            && isset($json['code'])
            && strtolower((string) $json['code']) !== 'ok'
            && strtolower((string) $json['code']) !== 'success'
        ) {
            throw new \RuntimeException('Termii API error: '.json_encode($json));
        }
    }
}
