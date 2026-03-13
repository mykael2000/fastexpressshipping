<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoPayment;
use App\Models\Shipment;
use App\Models\ShipmentRequest;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shipments' => Shipment::count(),
            'total_requests' => ShipmentRequest::count(),
            'pending_requests' => ShipmentRequest::where('status', 'pending')->count(),
            'pending_payments' => CryptoPayment::whereIn('status', ['submitted'])->count(),
            'total_users' => User::count(),
        ];
        $recentRequests = ShipmentRequest::with('user')->latest()->take(5)->get();
        $recentShipments = Shipment::latest()->take(5)->get();
        return view('admin.dashboard', compact('stats', 'recentRequests', 'recentShipments'));
    }
}
