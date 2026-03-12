<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\TrackingEventController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TrackingController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────
Route::get('/', [TrackingController::class, 'index'])->name('home');

Route::middleware(['throttle:tracking'])->group(function () {
    Route::post('/track', [TrackingController::class, 'track'])->name('track');
    Route::get('/track/{trackingNumber}', [TrackingController::class, 'show'])->name('track.show');
});

// ── Auth Routes (Breeze) ───────────────────────────────────────
require __DIR__.'/auth.php';

// ── Admin Routes ───────────────────────────────────────────────
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('shipments', ShipmentController::class);

    Route::prefix('shipments/{shipment}/events')->name('shipments.events.')->group(function () {
        Route::get('/create', [TrackingEventController::class, 'create'])->name('create');
        Route::post('/', [TrackingEventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [TrackingEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [TrackingEventController::class, 'update'])->name('update');
        Route::delete('/{event}', [TrackingEventController::class, 'destroy'])->name('destroy');
    });
});

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Breeze dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
