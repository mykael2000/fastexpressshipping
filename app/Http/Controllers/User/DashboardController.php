<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\PackageItem;
use App\Models\ShipmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $requests = Auth::user()->shipmentRequests()->latest()->paginate(10);
        return view('user.dashboard.index', compact('requests'));
    }

    public function createRequest()
    {
        return view('user.requests.create');
    }

    public function storeRequest(Request $request)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'sender_phone' => 'required|string|max:30',
            'sender_address1' => 'required|string|max:255',
            'sender_address2' => 'nullable|string|max:255',
            'sender_city' => 'required|string|max:100',
            'sender_state' => 'nullable|string|max:100',
            'sender_postal' => 'required|string|max:20',
            'sender_country' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'recipient_email' => 'required|email|max:255',
            'recipient_phone' => 'required|string|max:30',
            'recipient_address1' => 'required|string|max:255',
            'recipient_address2' => 'nullable|string|max:255',
            'recipient_city' => 'required|string|max:100',
            'recipient_state' => 'nullable|string|max:100',
            'recipient_postal' => 'required|string|max:20',
            'recipient_country' => 'required|string|max:100',
            'pickup_type' => 'required|in:dropoff,scheduled',
            'pickup_date' => 'nullable|date|after_or_equal:today',
            'pickup_time_window' => 'nullable|string|max:100',
            'pickup_instructions' => 'nullable|string|max:1000',
            'service_level' => 'required|in:standard,express,overnight',
            'signature_required' => 'nullable|boolean',
            'insurance_required' => 'nullable|boolean',
            'delivery_instructions' => 'nullable|string|max:1000',
            'prohibited_items_acknowledged' => 'required|accepted',
            'terms_accepted' => 'required|accepted',
            'notes' => 'nullable|string|max:2000',
            'packages' => 'required|array|min:1',
            'packages.*.package_type' => 'required|string|max:50',
            'packages.*.quantity' => 'required|integer|min:1|max:99',
            'packages.*.weight' => 'required|numeric|min:0.1',
            'packages.*.weight_unit' => 'required|in:kg,lb',
            'packages.*.length' => 'nullable|numeric|min:0',
            'packages.*.width' => 'nullable|numeric|min:0',
            'packages.*.height' => 'nullable|numeric|min:0',
            'packages.*.dimension_unit' => 'required|in:cm,in',
            'packages.*.declared_value' => 'nullable|numeric|min:0',
            'packages.*.currency' => 'required|string|max:3',
            'packages.*.contents_description' => 'required|string|max:500',
            'packages.*.hs_code' => 'nullable|string|max:20',
        ]);

        $shipmentRequest = ShipmentRequest::create(array_merge(
            $validated,
            [
                'user_id' => Auth::id(),
                'status' => 'pending',
                'signature_required' => $request->boolean('signature_required'),
                'insurance_required' => $request->boolean('insurance_required'),
                'prohibited_items_acknowledged' => true,
                'terms_accepted' => true,
            ]
        ));

        foreach ($validated['packages'] as $pkg) {
            $shipmentRequest->packageItems()->create($pkg);
        }

        return redirect()->route('user.requests.show', $shipmentRequest)
            ->with('success', 'Your shipment request has been submitted successfully. We will review it shortly.');
    }

    public function showRequest(ShipmentRequest $request)
    {
        $this->authorize('view', $request);
        $request->load(['packageItems', 'cryptoPayments', 'shipment']);
        return view('user.requests.show', compact('request'));
    }
}
