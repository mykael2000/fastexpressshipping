<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendShipmentNotification;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShipmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Shipment::query()->latest();

        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('tracking_number', 'like', "%{$q}%")
                   ->orWhere('recipient_name', 'like', "%{$q}%")
                   ->orWhere('recipient_email', 'like', "%{$q}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $shipments = $query->paginate(20)->withQueryString();

        return view('admin.shipments.index', [
            'shipments' => $shipments,
            'statusOptions' => Shipment::statusOptions(),
        ]);
    }

    public function create()
    {
        return view('admin.shipments.create', [
            'statusOptions' => Shipment::statusOptions(),
            'serviceLevelOptions' => Shipment::serviceLevelOptions(),
            'paymentModeOptions' => Shipment::paymentModeOptions(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['updated_by'] = auth()->id();
        $data['tracking_number'] = strtoupper($data['tracking_number'] ?? Str::upper(Str::random(12)));

        $shipment = Shipment::create($data);

        if ($shipment->notify_email || $shipment->notify_sms) {
            dispatch(new SendShipmentNotification($shipment, 'status_change', $shipment->status));
        }

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment created successfully.');
    }

    public function show(Shipment $shipment)
    {
        $shipment->load(['trackingEvents', 'notificationLogs']);
        return view('admin.shipments.show', compact('shipment'));
    }

    public function edit(Shipment $shipment)
    {
        return view('admin.shipments.edit', [
            'shipment' => $shipment,
            'statusOptions' => Shipment::statusOptions(),
            'serviceLevelOptions' => Shipment::serviceLevelOptions(),
            'paymentModeOptions' => Shipment::paymentModeOptions(),
        ]);
    }

    public function update(Request $request, Shipment $shipment)
    {
        $data = $this->validated($request, $shipment->id);
        $oldStatus = $shipment->status;
        $data['updated_by'] = auth()->id();

        $shipment->update($data);

        if ($data['status'] !== $oldStatus) {
            dispatch(new SendShipmentNotification($shipment->fresh(), 'status_change', $data['status']));
        }

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Shipment updated successfully.');
    }

    public function destroy(Shipment $shipment)
    {
        $shipment->delete();
        return redirect()->route('admin.shipments.index')
            ->with('success', 'Shipment deleted.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $trackingUnique = 'unique:shipments,tracking_number';
        if ($ignoreId) {
            $trackingUnique .= ',' . $ignoreId;
        }

        return $request->validate([
            'tracking_number'  => ['required', 'string', 'max:50', 'regex:/^[A-Za-z0-9\-]+$/', $trackingUnique],
            'status'           => ['required', 'string', 'in:' . implode(',', array_keys(Shipment::statusOptions()))],
            'origin'           => ['required', 'string', 'max:255'],
            'destination'      => ['required', 'string', 'max:255'],
            'recipient_name'   => ['required', 'string', 'max:255'],
            'recipient_email'  => ['nullable', 'email', 'max:255'],
            'recipient_phone'  => ['nullable', 'string', 'max:30'],
            'eta'              => ['nullable', 'date'],
            'shipped_date'     => ['nullable', 'date'],
            'service_level'    => ['required', 'string', 'in:' . implode(',', array_keys(Shipment::serviceLevelOptions()))],
            'notes'            => ['nullable', 'string', 'max:2000'],
            'payment_mode'     => ['nullable', 'string', 'in:' . implode(',', array_keys(Shipment::paymentModeOptions()))],
            'weight_kg'        => ['nullable', 'numeric', 'min:0'],
            'remark'           => ['nullable', 'string', 'max:2000'],
            'notify_email'     => ['boolean'],
            'notify_sms'       => ['boolean'],
        ]);
    }
}
