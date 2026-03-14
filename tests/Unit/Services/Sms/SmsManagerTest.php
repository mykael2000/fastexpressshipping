<?php

namespace Tests\Unit\Services\Sms;

use App\Services\Sms\SmsClient;
use App\Services\Sms\SmsManager;
use PHPUnit\Framework\TestCase;

class SmsManagerTest extends TestCase
{
    private function makeClient(string $name, bool $configured, ?\Throwable $throws = null): SmsClient
    {
        $client = $this->createMock(SmsClient::class);
        $client->method('name')->willReturn($name);
        $client->method('isConfigured')->willReturn($configured);

        if ($throws !== null) {
            $client->method('send')->willThrowException($throws);
        }

        return $client;
    }

    private function makeManager(array $clients, string $primary = 'termii', string $fallback = 'twilio'): SmsManager
    {
        // Stub config() calls used by SmsManager via a wrapper approach.
        // Since SmsManager reads config() directly we swap the approach:
        // we create a testable subclass that overrides config reading.
        return new class($clients, $primary, $fallback) extends SmsManager
        {
            public function __construct(array $clients, private string $primaryName, private string $fallbackName)
            {
                parent::__construct($clients);
            }

            protected function getPrimaryName(): string
            {
                return $this->primaryName;
            }

            protected function getFallbackName(): string
            {
                return $this->fallbackName;
            }

            protected function logWarning(string $message): void
            {
                // No-op in tests — avoids the need for a Laravel app container.
            }
        };
    }

    public function test_sends_via_primary_when_configured(): void
    {
        $termii = $this->makeClient('termii', true);
        $termii->expects($this->once())->method('send');

        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->never())->method('send');

        $manager = $this->makeManager(['termii' => $termii, 'twilio' => $twilio]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('termii', $result);
    }

    public function test_falls_back_to_secondary_when_primary_throws(): void
    {
        $termii = $this->makeClient('termii', true, new \RuntimeException('Termii down'));
        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->once())->method('send');

        $manager = $this->makeManager(['termii' => $termii, 'twilio' => $twilio]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('twilio', $result);
    }

    public function test_skips_unconfigured_primary_and_uses_fallback(): void
    {
        $termii = $this->makeClient('termii', false);
        $termii->expects($this->never())->method('send');

        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->once())->method('send');

        $manager = $this->makeManager(['termii' => $termii, 'twilio' => $twilio]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('twilio', $result);
    }

    public function test_throws_when_no_providers_configured(): void
    {
        $termii = $this->makeClient('termii', false);
        $twilio = $this->makeClient('twilio', false);

        $manager = $this->makeManager(['termii' => $termii, 'twilio' => $twilio]);

        $this->expectException(\RuntimeException::class);
        $manager->send('+2348012345678', 'Hello');
    }

    public function test_throws_when_both_providers_fail(): void
    {
        $termii = $this->makeClient('termii', true, new \RuntimeException('Termii error'));
        $twilio = $this->makeClient('twilio', true, new \RuntimeException('Twilio error'));

        $manager = $this->makeManager(['termii' => $termii, 'twilio' => $twilio]);

        $this->expectException(\RuntimeException::class);
        $manager->send('+2348012345678', 'Hello');
    }
}
