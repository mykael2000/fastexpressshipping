<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'shipment_request_id', 'package_type', 'quantity',
        'weight', 'weight_unit', 'length', 'width', 'height', 'dimension_unit',
        'declared_value', 'currency', 'contents_description', 'hs_code',
    ];

    protected $casts = [
        'weight' => 'decimal:3',
        'length' => 'decimal:2',
        'width' => 'decimal:2',
        'height' => 'decimal:2',
        'declared_value' => 'decimal:2',
    ];

    public function shipmentRequest()
    {
        return $this->belongsTo(ShipmentRequest::class);
    }
}
