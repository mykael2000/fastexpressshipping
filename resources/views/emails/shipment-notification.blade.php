<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 30px auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #1a3a6b; padding: 24px 32px; }
        .header h1 { color: #f97316; margin: 0; font-size: 22px; }
        .header p { color: #ccd9f0; margin: 4px 0 0; font-size: 13px; }
        .body { padding: 32px; }
        .body h2 { color: #1a3a6b; margin-top: 0; }
        .status-badge { display: inline-block; padding: 6px 16px; background: #f97316; color: #fff; border-radius: 4px; font-weight: bold; font-size: 14px; }
        .detail-table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        .detail-table td { padding: 8px 12px; border-bottom: 1px solid #eee; font-size: 14px; }
        .detail-table td:first-child { font-weight: bold; color: #555; width: 40%; }
        .cta { display: block; margin: 24px 0; text-align: center; }
        .cta a { background: #1a3a6b; color: #fff; padding: 12px 32px; border-radius: 6px; text-decoration: none; font-size: 15px; }
        .footer { background: #f5f5f5; padding: 16px 32px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h1>Fast Express Shipping</h1>
        <p>Your reliable shipping partner</p>
    </div>
    <div class="body">
        <h2>Shipment Update</h2>
        <p>Hello {{ $shipment->recipient_name }},</p>
        @if($trigger === 'status_change')
            <p>Your shipment status has been updated:</p>
            <p><span class="status-badge">{{ $shipment->statusLabel() }}</span></p>
        @else
            <p>There is a new update on your shipment.</p>
        @endif

        <table class="detail-table">
            <tr><td>Tracking Number</td><td>{{ $shipment->tracking_number }}</td></tr>
            <tr><td>Status</td><td>{{ $shipment->statusLabel() }}</td></tr>
            <tr><td>Origin</td><td>{{ $shipment->origin }}</td></tr>
            <tr><td>Destination</td><td>{{ $shipment->destination }}</td></tr>
            <tr><td>Service Level</td><td>{{ ucfirst($shipment->service_level) }}</td></tr>
            @if($shipment->eta)
            <tr><td>Estimated Delivery</td><td>{{ $shipment->eta->format('M d, Y') }}</td></tr>
            @endif
        </table>

        <div class="cta">
            <a href="{{ url('/track/' . $shipment->tracking_number) }}">Track Your Shipment</a>
        </div>

        <p style="font-size: 13px; color: #888;">If you did not expect this email, please disregard it.</p>
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Fast Express Shipping. All rights reserved.
    </div>
</div>
</body>
</html>
