<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoPayment;
use App\Models\Shipment;
use App\Models\ShipmentRequest;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ShipmentRequestController extends Controller
{
    public function index(Request $request)
    {
        $query = ShipmentRequest::with(['user', 'packageItems'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $requests = $query->paginate(20);
        return view('admin.shipment-requests.index', compact('requests'));
    }

    public function show(ShipmentRequest $shipmentRequest)
    {
        $shipmentRequest->load(['user', 'packageItems', 'cryptoPayments', 'shipment', 'reviewer']);
        return view('admin.shipment-requests.show', compact('shipmentRequest'));
    }

    public function approve(ShipmentRequest $shipmentRequest)
    {
        $shipmentRequest->update([
            'status' => 'approved',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);
        return back()->with('success', 'Request approved.');
    }

    public function deny(Request $request, ShipmentRequest $shipmentRequest)
    {
        $validated = $request->validate(['admin_notes' => 'nullable|string|max:1000']);
        $shipmentRequest->update([
            'status' => 'denied',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $validated['admin_notes'] ?? null,
        ]);
        return back()->with('success', 'Request denied.');
    }

    public function requirePayment(Request $request, ShipmentRequest $shipmentRequest)
    {
        $validated = $request->validate([
            'coin' => 'required|in:BTC,ETH,USDT_TRC20',
            'amount_usd' => 'required|numeric|min:1',
        ]);

        $walletKey = 'wallet_' . strtolower($validated['coin']);
        $walletAddress = SiteSetting::get($walletKey, '');

        CryptoPayment::create([
            'shipment_request_id' => $shipmentRequest->id,
            'user_id' => $shipmentRequest->user_id,
            'coin' => $validated['coin'],
            'wallet_address' => $walletAddress,
            'amount_usd' => $validated['amount_usd'],
            'status' => 'pending',
            'expires_at' => now()->addHours(48),
        ]);

        $shipmentRequest->update([
            'status' => 'payment_required',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
        ]);

        return back()->with('success', 'Payment request created.');
    }

    public function createShipment(ShipmentRequest $shipmentRequest)
    {
        if ($shipmentRequest->status !== 'approved') {
            return back()->withErrors(['error' => 'Request must be approved first.']);
        }
        return view('admin.shipment-requests.create-shipment', compact('shipmentRequest'));
    }

    public function storeShipment(Request $request, ShipmentRequest $shipmentRequest)
    {
        $validated = $request->validate([
            'service_level' => 'required|in:standard,express,overnight',
            'notes' => 'nullable|string|max:1000',
        ]);

        $trackingNumber = 'FES' . strtoupper(Str::random(10));

        $shipment = Shipment::create([
            'tracking_number' => $trackingNumber,
            'status' => 'created',
            'origin' => $shipmentRequest->sender_city . ', ' . $shipmentRequest->sender_country,
            'destination' => $shipmentRequest->recipient_city . ', ' . $shipmentRequest->recipient_country,
            'recipient_name' => $shipmentRequest->recipient_name,
            'recipient_email' => $shipmentRequest->recipient_email,
            'recipient_phone' => $shipmentRequest->recipient_phone,
            'service_level' => $validated['service_level'],
            'notes' => $validated['notes'],
            'notify_email' => true,
            'notify_sms' => false,
            'updated_by' => Auth::id(),
        ]);

        $shipmentRequest->update(['shipment_id' => $shipment->id]);

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', "Shipment created with tracking number: {$trackingNumber}");
    }
}
