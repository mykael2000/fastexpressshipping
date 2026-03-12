<?php
use App\Http\Controllers\Admin\CryptoPaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\NewsPostController;
use App\Http\Controllers\Admin\ServiceAlertController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\ShipmentRequestController;
use App\Http\Controllers\Admin\SiteSettingController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\TrackingEventController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicPageController;
use App\Http\Controllers\TrackingController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\User\PaymentController;
use Illuminate\Support\Facades\Route;

// ── Public Routes ──────────────────────────────────────────────
Route::get('/', [TrackingController::class, 'index'])->name('home');
Route::get('/services', [PublicPageController::class, 'services'])->name('services');
Route::get('/about', [PublicPageController::class, 'about'])->name('about');
Route::get('/contact', [PublicPageController::class, 'contact'])->name('contact');
Route::get('/faq', [PublicPageController::class, 'faq'])->name('faq');
Route::get('/service-alerts', [PublicPageController::class, 'serviceAlerts'])->name('service-alerts');
Route::get('/news', [PublicPageController::class, 'newsIndex'])->name('news.index');
Route::get('/news/{slug}', [PublicPageController::class, 'newsShow'])->name('news.show');
Route::get('/pages/{slug}', [PublicPageController::class, 'page'])->name('pages.show');

Route::middleware(['throttle:tracking'])->group(function () {
    Route::post('/track', [TrackingController::class, 'track'])->name('track');
    Route::get('/track/{trackingNumber}', [TrackingController::class, 'show'])->name('track.show');
});

// ── Auth Routes (Breeze) ───────────────────────────────────────
require __DIR__.'/auth.php';

// ── User Dashboard Routes ──────────────────────────────────────
Route::middleware(['auth', 'verified'])->prefix('my')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->name('dashboard');
    Route::get('/requests/create', [UserDashboardController::class, 'createRequest'])->name('requests.create');
    Route::post('/requests', [UserDashboardController::class, 'storeRequest'])->name('requests.store');
    Route::get('/requests/{request}', [UserDashboardController::class, 'showRequest'])->name('requests.show');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/proof', [PaymentController::class, 'submitProof'])->name('payments.proof');
});

// ── Admin Routes ───────────────────────────────────────────────
Route::middleware(['auth', 'verified', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Existing shipments
    Route::resource('shipments', ShipmentController::class);
    Route::prefix('shipments/{shipment}/events')->name('shipments.events.')->group(function () {
        Route::get('/create', [TrackingEventController::class, 'create'])->name('create');
        Route::post('/', [TrackingEventController::class, 'store'])->name('store');
        Route::get('/{event}/edit', [TrackingEventController::class, 'edit'])->name('edit');
        Route::put('/{event}', [TrackingEventController::class, 'update'])->name('update');
        Route::delete('/{event}', [TrackingEventController::class, 'destroy'])->name('destroy');
    });

    // Shipment requests
    Route::get('shipment-requests', [ShipmentRequestController::class, 'index'])->name('shipment-requests.index');
    Route::get('shipment-requests/{shipmentRequest}', [ShipmentRequestController::class, 'show'])->name('shipment-requests.show');
    Route::post('shipment-requests/{shipmentRequest}/approve', [ShipmentRequestController::class, 'approve'])->name('shipment-requests.approve');
    Route::post('shipment-requests/{shipmentRequest}/deny', [ShipmentRequestController::class, 'deny'])->name('shipment-requests.deny');
    Route::post('shipment-requests/{shipmentRequest}/require-payment', [ShipmentRequestController::class, 'requirePayment'])->name('shipment-requests.require-payment');
    Route::get('shipment-requests/{shipmentRequest}/create-shipment', [ShipmentRequestController::class, 'createShipment'])->name('shipment-requests.create-shipment');
    Route::post('shipment-requests/{shipmentRequest}/create-shipment', [ShipmentRequestController::class, 'storeShipment'])->name('shipment-requests.store-shipment');

    // Crypto payments
    Route::get('crypto-payments', [CryptoPaymentController::class, 'index'])->name('crypto-payments.index');
    Route::get('crypto-payments/{cryptoPayment}', [CryptoPaymentController::class, 'show'])->name('crypto-payments.show');
    Route::post('crypto-payments/{cryptoPayment}/mark-paid', [CryptoPaymentController::class, 'markPaid'])->name('crypto-payments.mark-paid');
    Route::post('crypto-payments/{cryptoPayment}/mark-rejected', [CryptoPaymentController::class, 'markRejected'])->name('crypto-payments.mark-rejected');

    // News posts
    Route::resource('news-posts', NewsPostController::class);

    // Service alerts
    Route::resource('service-alerts', ServiceAlertController::class);

    // Static pages
    Route::resource('static-pages', StaticPageController::class);

    // Site settings
    Route::get('site-settings', [SiteSettingController::class, 'index'])->name('site-settings.index');
    Route::post('site-settings', [SiteSettingController::class, 'update'])->name('site-settings.update');

    // Users (admin-only)
    Route::middleware('role:admin')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
    });
});

// Profile (Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Dashboard redirect
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');
