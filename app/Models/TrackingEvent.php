<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_id', 'occurred_at', 'location', 'event_type', 'description', 'updated_by',
    ];

    protected $casts = [
        'occurred_at' => 'datetime',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public static function eventTypeOptions(): array
    {
        return [
            'pickup' => 'Package Picked Up',
            'transit' => 'In Transit',
            'delivery_attempt' => 'Delivery Attempted',
            'out_for_delivery' => 'Out for Delivery',
            'delivered' => 'Delivered',
            'exception' => 'Exception / Alert',
            'info' => 'Informational',
        ];
    }
}
