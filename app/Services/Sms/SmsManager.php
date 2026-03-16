<?php

namespace App\Services\Sms;

use Illuminate\Support\Facades\Log;

class SmsManager
{
    /** @var array<string, SmsClient> */
    private array $clients;

    /**
     * @param  array<string, SmsClient>  $clients  Keyed by provider name
     */
    public function __construct(array $clients)
    {
        $this->clients = $clients;
    }

    /**
     * Send an SMS, trying the primary provider then the fallback.
     *
     * @return string The name of the provider that successfully sent the message.
     *
     * @throws \RuntimeException When no configured provider succeeds.
     */
    public function send(string $to, string $message): string
    {
        $primaryName = $this->getPrimaryName();
        $fallbackName = $this->getFallbackName();

        $primary = $this->resolve($primaryName);
        $fallback = $this->resolve($fallbackName);

        if ($primary === null && $fallback === null) {
            throw new \RuntimeException('No SMS provider is configured.');
        }

        if ($primary !== null && $primary->isConfigured()) {
            try {
                $primary->send($to, $message);

                return $primary->name();
            } catch (\Throwable $e) {
                $this->logWarning("SMS primary provider [{$primary->name()}] failed: ".$e->getMessage());
            }
        }

        if ($fallback !== null && $fallback->isConfigured()) {
            $fallback->send($to, $message);

            return $fallback->name();
        }

        throw new \RuntimeException('All configured SMS providers failed or are not configured.');
    }

    protected function getPrimaryName(): string
    {
        return (string) config('services.sms.provider', 'twilio');
    }

    protected function getFallbackName(): string
    {
        return (string) config('services.sms.fallback_provider', 'sns');
    }

    protected function logWarning(string $message): void
    {
        Log::warning($message);
    }

    private function resolve(?string $name): ?SmsClient
    {
        if ($name === null || $name === '') {
            return null;
        }

        return $this->clients[$name] ?? null;
    }
}
