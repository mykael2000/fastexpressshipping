<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Shipment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total'        => Shipment::count(),
            'in_transit'   => Shipment::where('status', 'in_transit')->count(),
            'delivered'    => Shipment::where('status', 'delivered')->count(),
            'exception'    => Shipment::where('status', 'exception')->count(),
        ];

        $recentShipments = Shipment::latest()->take(10)->get();
        $recentLogs      = NotificationLog::with('shipment')->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentShipments', 'recentLogs'));
    }
}
