<?php
namespace Database\Seeders;

use App\Models\ServiceAlert;
use Illuminate\Database\Seeder;

class ServiceAlertSeeder extends Seeder
{
    public function run(): void
    {
        $alerts = [
            [
                'title' => 'Holiday Season Shipping Deadlines',
                'message' => 'To ensure delivery before December 25th, please submit your Standard shipping requests by December 15th, Express by December 20th, and Overnight by December 23rd.',
                'type' => 'info',
                'is_active' => false,
                'starts_at' => now()->subDays(60),
                'ends_at' => now()->subDays(10),
            ],
            [
                'title' => 'Scheduled Maintenance — Tracking Portal',
                'message' => 'Our tracking portal will undergo scheduled maintenance on Sunday between 2:00 AM and 4:00 AM UTC. Tracking may be temporarily unavailable during this window.',
                'type' => 'warning',
                'is_active' => true,
                'starts_at' => now(),
                'ends_at' => now()->addDays(3),
            ],
            [
                'title' => 'Extended Processing Times in Southeast Asia',
                'message' => 'Due to increased shipment volumes, processing times for destinations in Southeast Asia may be extended by 1-2 business days. We apologize for any inconvenience.',
                'type' => 'warning',
                'is_active' => true,
                'starts_at' => null,
                'ends_at' => now()->addDays(14),
            ],
            [
                'title' => 'New Service: Express Delivery to West Africa',
                'message' => 'We are pleased to announce Express delivery service is now available to Nigeria, Ghana, Senegal, and Côte d\'Ivoire with 3-5 business day delivery.',
                'type' => 'success',
                'is_active' => true,
                'starts_at' => now()->subDays(7),
                'ends_at' => null,
            ],
        ];

        foreach ($alerts as $alert) {
            ServiceAlert::create($alert);
        }
    }
}
