<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    protected $fillable = [
        'shipment_id', 'channel', 'recipient', 'trigger', 'trigger_value', 'status', 'message',
    ];

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
