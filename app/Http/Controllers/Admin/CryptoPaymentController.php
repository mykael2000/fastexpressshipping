<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CryptoPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CryptoPaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = CryptoPayment::with(['user', 'shipmentRequest'])->latest();
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        $payments = $query->paginate(20);
        return view('admin.crypto-payments.index', compact('payments'));
    }

    public function show(CryptoPayment $cryptoPayment)
    {
        $cryptoPayment->load(['user', 'shipmentRequest', 'reviewer']);
        return view('admin.crypto-payments.show', compact('cryptoPayment'));
    }

    public function markPaid(Request $request, CryptoPayment $cryptoPayment)
    {
        $cryptoPayment->update([
            'status' => 'paid',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);

        // Also approve the request if it's still payment_required
        $sr = $cryptoPayment->shipmentRequest;
        if ($sr && $sr->status === 'payment_required') {
            $sr->update(['status' => 'approved', 'reviewed_by' => Auth::id(), 'reviewed_at' => now()]);
        }

        return back()->with('success', 'Payment marked as paid.');
    }

    public function markRejected(Request $request, CryptoPayment $cryptoPayment)
    {
        $cryptoPayment->update([
            'status' => 'rejected',
            'reviewed_by' => Auth::id(),
            'reviewed_at' => now(),
            'admin_notes' => $request->input('admin_notes'),
        ]);
        return back()->with('success', 'Payment marked as rejected.');
    }
}
