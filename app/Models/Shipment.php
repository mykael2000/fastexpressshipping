<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'tracking_number', 'status', 'origin', 'destination',
        'recipient_name', 'recipient_email', 'recipient_phone',
        'eta', 'shipped_date', 'service_level', 'notes',
        'notify_email', 'notify_sms', 'updated_by',
    ];

    protected $casts = [
        'eta' => 'datetime',
        'shipped_date' => 'datetime',
        'notify_email' => 'boolean',
        'notify_sms' => 'boolean',
    ];

    public function trackingEvents()
    {
        return $this->hasMany(TrackingEvent::class)->orderByDesc('occurred_at');
    }

    public function notificationLogs()
    {
        return $this->hasMany(NotificationLog::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function statusOptions(): array
    {
        return [
            'created' => 'Label Created',
            'picked_up' => 'Picked Up',
            'in_transit' => 'In Transit',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'exception' => 'Exception',
        ];
    }

    public static function serviceLevelOptions(): array
    {
        return [
            'standard' => 'Standard',
            'express' => 'Express',
            'overnight' => 'Overnight',
        ];
    }

    public function statusLabel(): string
    {
        return static::statusOptions()[$this->status] ?? ucfirst($this->status);
    }
}
