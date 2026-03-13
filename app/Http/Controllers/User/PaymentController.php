<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CryptoPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    public function show(CryptoPayment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }
        $payment->load('shipmentRequest');
        return view('user.payments.show', compact('payment'));
    }

    public function submitProof(Request $request, CryptoPayment $payment)
    {
        if ($payment->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'tx_hash' => 'nullable|string|max:255',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $path = $request->file('proof')->store('payment-proofs', 'public');

        $payment->update([
            'tx_hash' => $validated['tx_hash'] ?? null,
            'proof_path' => $path,
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Payment proof submitted. Our team will verify it shortly.');
    }
}
