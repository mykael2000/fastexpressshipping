<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CryptoPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_request_id', 'user_id', 'coin', 'network',
        'wallet_address', 'amount_usd', 'amount_crypto', 'status',
        'tx_hash', 'proof_path', 'expires_at',
        'reviewed_by', 'reviewed_at', 'admin_notes',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'reviewed_at' => 'datetime',
        'amount_usd' => 'decimal:2',
        'amount_crypto' => 'decimal:8',
    ];

    public static function statusOptions(): array
    {
        return [
            'pending' => 'Pending',
            'submitted' => 'Proof Submitted',
            'paid' => 'Paid',
            'rejected' => 'Rejected',
            'expired' => 'Expired',
        ];
    }

    public function statusLabel(): string
    {
        return static::statusOptions()[$this->status] ?? ucfirst($this->status);
    }

    public function shipmentRequest()
    {
        return $this->belongsTo(ShipmentRequest::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
