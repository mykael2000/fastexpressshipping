<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\SendShipmentNotification;
use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Http\Request;

class TrackingEventController extends Controller
{
    public function create(Shipment $shipment)
    {
        return view('admin.events.create', [
            'shipment' => $shipment,
            'eventTypeOptions' => TrackingEvent::eventTypeOptions(),
        ]);
    }

    public function store(Request $request, Shipment $shipment)
    {
        $data = $request->validate([
            'occurred_at' => ['required', 'date'],
            'location'    => ['nullable', 'string', 'max:255'],
            'event_type'  => ['required', 'string', 'in:' . implode(',', array_keys(TrackingEvent::eventTypeOptions()))],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $data['shipment_id'] = $shipment->id;
        $data['updated_by']  = auth()->id();

        $event = TrackingEvent::create($data);

        dispatch(new SendShipmentNotification($shipment, 'new_event', (string) $event->id));

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Tracking event added.');
    }

    public function edit(Shipment $shipment, TrackingEvent $event)
    {
        abort_unless($event->shipment_id === $shipment->id, 404);
        return view('admin.events.edit', [
            'shipment' => $shipment,
            'event' => $event,
            'eventTypeOptions' => TrackingEvent::eventTypeOptions(),
        ]);
    }

    public function update(Request $request, Shipment $shipment, TrackingEvent $event)
    {
        abort_unless($event->shipment_id === $shipment->id, 404);

        $data = $request->validate([
            'occurred_at' => ['required', 'date'],
            'location'    => ['nullable', 'string', 'max:255'],
            'event_type'  => ['required', 'string', 'in:' . implode(',', array_keys(TrackingEvent::eventTypeOptions()))],
            'description' => ['required', 'string', 'max:1000'],
        ]);

        $data['updated_by'] = auth()->id();
        $event->update($data);

        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Tracking event updated.');
    }

    public function destroy(Shipment $shipment, TrackingEvent $event)
    {
        abort_unless($event->shipment_id === $shipment->id, 404);
        $event->delete();
        return redirect()->route('admin.shipments.show', $shipment)
            ->with('success', 'Tracking event deleted.');
    }
}
