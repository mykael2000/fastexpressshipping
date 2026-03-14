<?php

namespace App\Services\Sms;

use Twilio\Rest\Client;

class TwilioSmsClient implements SmsClient
{
    public function name(): string
    {
        return 'twilio';
    }

    public function isConfigured(): bool
    {
        return (bool) config('services.twilio.sid')
            && (bool) config('services.twilio.token')
            && (bool) config('services.twilio.from');
    }

    public function send(string $to, string $message): void
    {
        $sid = (string) config('services.twilio.sid');
        $token = (string) config('services.twilio.token');
        $from = (string) config('services.twilio.from');

        $client = new Client($sid, $token);
        $client->messages->create($to, ['from' => $from, 'body' => $message]);
    }
}
