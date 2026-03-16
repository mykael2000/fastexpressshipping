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

    private function makeManager(array $clients, string $primary = 'twilio', string $fallback = 'sns'): SmsManager
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
        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->once())->method('send');

        $sns = $this->makeClient('sns', true);
        $sns->expects($this->never())->method('send');

        $manager = $this->makeManager(['twilio' => $twilio, 'sns' => $sns]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('twilio', $result);
    }

    public function test_falls_back_to_secondary_when_primary_throws(): void
    {
        $twilio = $this->makeClient('twilio', true, new \RuntimeException('Twilio down'));
        $sns = $this->makeClient('sns', true);
        $sns->expects($this->once())->method('send');

        $manager = $this->makeManager(['twilio' => $twilio, 'sns' => $sns]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('sns', $result);
    }

    public function test_skips_unconfigured_primary_and_uses_fallback(): void
    {
        $twilio = $this->makeClient('twilio', false);
        $twilio->expects($this->never())->method('send');

        $sns = $this->makeClient('sns', true);
        $sns->expects($this->once())->method('send');

        $manager = $this->makeManager(['twilio' => $twilio, 'sns' => $sns]);
        $result = $manager->send('+2348012345678', 'Hello');

        $this->assertSame('sns', $result);
    }

    public function test_throws_when_no_providers_configured(): void
    {
        $twilio = $this->makeClient('twilio', false);
        $sns = $this->makeClient('sns', false);

        $manager = $this->makeManager(['twilio' => $twilio, 'sns' => $sns]);

        $this->expectException(\RuntimeException::class);
        $manager->send('+2348012345678', 'Hello');
    }

    public function test_throws_when_both_providers_fail(): void
    {
        $twilio = $this->makeClient('twilio', true, new \RuntimeException('Twilio error'));
        $sns = $this->makeClient('sns', true, new \RuntimeException('SNS error'));

        $manager = $this->makeManager(['twilio' => $twilio, 'sns' => $sns]);

        $this->expectException(\RuntimeException::class);
        $manager->send('+2348012345678', 'Hello');
    }

    // -----------------------------------------------------------------------
    // SNS-specific scenarios
    // -----------------------------------------------------------------------

    public function test_sns_as_primary_sends_successfully(): void
    {
        $sns = $this->makeClient('sns', true);
        $sns->expects($this->once())->method('send');

        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->never())->method('send');

        $manager = $this->makeManager(['sns' => $sns, 'twilio' => $twilio], 'sns', 'twilio');
        $result = $manager->send('+12125551234', 'Hello');

        $this->assertSame('sns', $result);
    }

    public function test_falls_back_to_twilio_when_sns_fails(): void
    {
        $sns = $this->makeClient('sns', true, new \RuntimeException('SNS error'));
        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->once())->method('send');

        $manager = $this->makeManager(['sns' => $sns, 'twilio' => $twilio], 'sns', 'twilio');
        $result = $manager->send('+12125551234', 'Hello');

        $this->assertSame('twilio', $result);
    }

    public function test_falls_back_to_twilio_when_sns_not_configured(): void
    {
        $sns = $this->makeClient('sns', false);
        $sns->expects($this->never())->method('send');

        $twilio = $this->makeClient('twilio', true);
        $twilio->expects($this->once())->method('send');

        $manager = $this->makeManager(['sns' => $sns, 'twilio' => $twilio], 'sns', 'twilio');
        $result = $manager->send('+12125551234', 'Hello');

        $this->assertSame('twilio', $result);
    }

    public function test_throws_when_sns_and_twilio_both_fail(): void
    {
        $sns = $this->makeClient('sns', true, new \RuntimeException('SNS error'));
        $twilio = $this->makeClient('twilio', true, new \RuntimeException('Twilio error'));

        $manager = $this->makeManager(['sns' => $sns, 'twilio' => $twilio], 'sns', 'twilio');

        $this->expectException(\RuntimeException::class);
        $manager->send('+12125551234', 'Hello');
    }
}
