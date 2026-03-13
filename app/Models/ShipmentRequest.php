<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipmentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'status',
        'sender_name', 'sender_email', 'sender_phone',
        'sender_address1', 'sender_address2', 'sender_city', 'sender_state', 'sender_postal', 'sender_country',
        'recipient_name', 'recipient_email', 'recipient_phone',
        'recipient_address1', 'recipient_address2', 'recipient_city', 'recipient_state', 'recipient_postal', 'recipient_country',
        'pickup_type', 'pickup_date', 'pickup_time_window', 'pickup_instructions',
        'service_level', 'signature_required', 'insurance_required', 'delivery_instructions',
        'prohibited_items_acknowledged', 'terms_accepted', 'notes',
        'reviewed_by', 'reviewed_at', 'admin_notes', 'shipment_id',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'reviewed_at' => 'datetime',
        'signature_required' => 'boolean',
        'insurance_required' => 'boolean',
        'prohibited_items_acknowledged' => 'boolean',
        'terms_accepted' => 'boolean',
    ];

    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending Review',
            'under_review' => 'Under Review',
            'payment_required' => 'Payment Required',
            'approved' => 'Approved',
            'denied' => 'Denied',
            'cancelled' => 'Cancelled',
        ];
    }

    public function statusLabel(): string
    {
        return static::statusOptions()[$this->status] ?? ucfirst($this->status);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function packageItems()
    {
        return $this->hasMany(PackageItem::class);
    }

    public function cryptoPayments()
    {
        return $this->hasMany(CryptoPayment::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function shipment()
    {
        return $this->belongsTo(Shipment::class);
    }
}
