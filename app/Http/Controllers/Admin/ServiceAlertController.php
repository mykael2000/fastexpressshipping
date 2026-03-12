<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceAlert;
use Illuminate\Http\Request;

class ServiceAlertController extends Controller
{
    public function index()
    {
        $alerts = ServiceAlert::latest()->paginate(20);
        return view('admin.service-alerts.index', compact('alerts'));
    }

    public function create()
    {
        return view('admin.service-alerts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,danger,success',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        ServiceAlert::create($validated);
        return redirect()->route('admin.service-alerts.index')->with('success', 'Alert created.');
    }

    public function edit(ServiceAlert $serviceAlert)
    {
        return view('admin.service-alerts.edit', compact('serviceAlert'));
    }

    public function update(Request $request, ServiceAlert $serviceAlert)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:info,warning,danger,success',
            'is_active' => 'nullable|boolean',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
        ]);
        $validated['is_active'] = $request->boolean('is_active');
        $serviceAlert->update($validated);
        return redirect()->route('admin.service-alerts.index')->with('success', 'Alert updated.');
    }

    public function destroy(ServiceAlert $serviceAlert)
    {
        $serviceAlert->delete();
        return redirect()->route('admin.service-alerts.index')->with('success', 'Alert deleted.');
    }
}
