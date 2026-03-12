<?php
namespace App\Http\Controllers;

use App\Models\Shipment;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index');
    }

    public function track(Request $request)
    {
        $request->validate([
            'tracking_number' => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/'],
        ]);

        $shipment = Shipment::with('trackingEvents')
            ->where('tracking_number', strtoupper($request->tracking_number))
            ->first();

        if (!$shipment) {
            return back()->withErrors(['tracking_number' => 'No shipment found with that tracking number. Please check and try again.'])->withInput();
        }

        return view('tracking.result', compact('shipment'));
    }

    public function show(string $trackingNumber)
    {
        $shipment = Shipment::with('trackingEvents')
            ->where('tracking_number', strtoupper($trackingNumber))
            ->firstOrFail();

        return view('tracking.result', compact('shipment'));
    }
}
