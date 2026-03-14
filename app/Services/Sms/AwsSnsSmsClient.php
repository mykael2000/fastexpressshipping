<?php

namespace App\Services\Sms;

use Aws\Sns\SnsClient;

class AwsSnsSmsClient implements SmsClient
{
    public function name(): string
    {
        return 'sns';
    }

    public function isConfigured(): bool
    {
        // The AWS SDK auto-discovers credentials via:
        //   1. AWS_ACCESS_KEY_ID / AWS_SECRET_ACCESS_KEY env vars
        //   2. ~/.aws/credentials file
        //   3. IAM instance / task role
        // We consider SNS configured as long as a region is available.
        return (bool) config('services.sns.region', env('AWS_DEFAULT_REGION', 'us-east-1'));
    }

    public function send(string $to, string $message): void
    {
        $region = (string) config('services.sns.region', config('services.ses.region', 'us-east-1'));

        $client = new SnsClient([
            'region' => $region,
            'version' => 'latest',
        ]);

        $attributes = [];

        $smsType = (string) config('services.sns.sms_type', 'Transactional');
        if ($smsType !== '') {
            $attributes['AWS.SNS.SMS.SMSType'] = [
                'DataType' => 'String',
                'StringValue' => $smsType,
            ];
        }

        $senderId = (string) config('services.sns.sender_id', '');
        if ($senderId !== '') {
            $attributes['AWS.SNS.SMS.SenderID'] = [
                'DataType' => 'String',
                'StringValue' => $senderId,
            ];
        }

        $params = [
            'Message' => $message,
            'PhoneNumber' => $to,
        ];

        if ($attributes !== []) {
            $params['MessageAttributes'] = $attributes;
        }

        $client->publish($params);
    }
}
