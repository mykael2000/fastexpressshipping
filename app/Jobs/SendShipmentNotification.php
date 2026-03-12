<?php
namespace App\Jobs;

use App\Models\NotificationLog;
use App\Models\Shipment;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendShipmentNotification implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(
        public readonly Shipment $shipment,
        public readonly string $trigger,      // 'status_change' | 'new_event'
        public readonly string $triggerValue, // new status | event id
    ) {}

    public function handle(): void
    {
        // ---- EMAIL ----
        if ($this->shipment->notify_email && $this->shipment->recipient_email) {
            $this->sendEmail();
        }

        // ---- SMS ----
        if ($this->shipment->notify_sms && $this->shipment->recipient_phone) {
            $this->sendSms();
        }
    }

    private function isDuplicate(string $channel, string $recipient): bool
    {
        return NotificationLog::where('shipment_id', $this->shipment->id)
            ->where('channel', $channel)
            ->where('recipient', $recipient)
            ->where('trigger', $this->trigger)
            ->where('trigger_value', $this->triggerValue)
            ->where('status', 'sent')
            ->exists();
    }

    private function sendEmail(): void
    {
        $recipient = $this->shipment->recipient_email;

        if ($this->isDuplicate('email', $recipient)) {
            Log::info("Skipping duplicate email for shipment #{$this->shipment->id}");
            return;
        }

        try {
            Mail::send('emails.shipment-notification', [
                'shipment' => $this->shipment,
                'trigger' => $this->trigger,
                'triggerValue' => $this->triggerValue,
            ], function ($message) use ($recipient) {
                $message->to($recipient, $this->shipment->recipient_name)
                    ->subject('Fast Express Shipping — Shipment Update: ' . $this->shipment->tracking_number);
            });

            NotificationLog::create([
                'shipment_id' => $this->shipment->id,
                'channel' => 'email',
                'recipient' => $recipient,
                'trigger' => $this->trigger,
                'trigger_value' => $this->triggerValue,
                'status' => 'sent',
                'message' => 'Email sent successfully.',
            ]);
        } catch (\Throwable $e) {
            Log::error("Email notification failed for shipment #{$this->shipment->id}: " . $e->getMessage());
            NotificationLog::create([
                'shipment_id' => $this->shipment->id,
                'channel' => 'email',
                'recipient' => $recipient,
                'trigger' => $this->trigger,
                'trigger_value' => $this->triggerValue,
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    private function sendSms(): void
    {
        $recipient = $this->shipment->recipient_phone;

        if ($this->isDuplicate('sms', $recipient)) {
            Log::info("Skipping duplicate SMS for shipment #{$this->shipment->id}");
            return;
        }

        $sid   = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from  = config('services.twilio.from');

        if (!$sid || !$token || !$from) {
            NotificationLog::create([
                'shipment_id' => $this->shipment->id,
                'channel' => 'sms',
                'recipient' => $recipient,
                'trigger' => $this->trigger,
                'trigger_value' => $this->triggerValue,
                'status' => 'skipped',
                'message' => 'Twilio credentials not configured.',
            ]);
            return;
        }

        try {
            $client = new \Twilio\Rest\Client($sid, $token);
            $body   = $this->buildSmsBody();
            $client->messages->create($recipient, ['from' => $from, 'body' => $body]);

            NotificationLog::create([
                'shipment_id' => $this->shipment->id,
                'channel' => 'sms',
                'recipient' => $recipient,
                'trigger' => $this->trigger,
                'trigger_value' => $this->triggerValue,
                'status' => 'sent',
                'message' => 'SMS sent successfully.',
            ]);
        } catch (\Throwable $e) {
            Log::error("SMS notification failed for shipment #{$this->shipment->id}: " . $e->getMessage());
            NotificationLog::create([
                'shipment_id' => $this->shipment->id,
                'channel' => 'sms',
                'recipient' => $recipient,
                'trigger' => $this->trigger,
                'trigger_value' => $this->triggerValue,
                'status' => 'failed',
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function buildSmsBody(): string
    {
        $s = $this->shipment;
        if ($this->trigger === 'status_change') {
            return "Fast Express Shipping: Your shipment {$s->tracking_number} status updated to: {$s->statusLabel()}. Track at " . url('/track/' . $s->tracking_number);
        }
        return "Fast Express Shipping: New update for shipment {$s->tracking_number}. Track at " . url('/track/' . $s->tracking_number);
    }
}
