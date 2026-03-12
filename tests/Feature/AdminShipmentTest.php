<?php
namespace Tests\Feature;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminShipmentTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['email_verified_at' => now()]);
    }

    public function test_admin_dashboard_requires_auth(): void
    {
        $this->get('/admin')->assertRedirect('/login');
    }

    public function test_admin_dashboard_loads_for_auth_user(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertStatus(200)
            ->assertSee('Dashboard');
    }

    public function test_admin_can_create_shipment(): void
    {
        $response = $this->actingAs($this->admin())
            ->post('/admin/shipments', [
                'tracking_number' => 'ADMIN001',
                'status' => 'created',
                'origin' => 'New York, NY',
                'destination' => 'Los Angeles, CA',
                'recipient_name' => 'John Doe',
                'recipient_email' => 'john@example.com',
                'service_level' => 'standard',
                'notify_email' => '1',
                'notify_sms' => '0',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('shipments', ['tracking_number' => 'ADMIN001']);
    }

    public function test_admin_can_update_shipment(): void
    {
        $shipment = Shipment::factory()->create(['status' => 'created']);

        $this->actingAs($this->admin())
            ->put("/admin/shipments/{$shipment->id}", array_merge($shipment->toArray(), [
                'status' => 'in_transit',
                'origin' => $shipment->origin,
                'destination' => $shipment->destination,
                'recipient_name' => $shipment->recipient_name,
                'service_level' => $shipment->service_level,
                'notify_email' => '1',
                'notify_sms' => '0',
            ]))
            ->assertRedirect();

        $this->assertDatabaseHas('shipments', ['id' => $shipment->id, 'status' => 'in_transit']);
    }

    public function test_admin_can_delete_shipment(): void
    {
        $shipment = Shipment::factory()->create();

        $this->actingAs($this->admin())
            ->delete("/admin/shipments/{$shipment->id}")
            ->assertRedirect('/admin/shipments');

        $this->assertDatabaseMissing('shipments', ['id' => $shipment->id]);
    }

    public function test_shipment_creation_requires_tracking_number(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/shipments', [
                'status' => 'created',
                'origin' => 'New York, NY',
                'destination' => 'LA',
                'recipient_name' => 'Test',
                'service_level' => 'standard',
            ])
            ->assertSessionHasErrors('tracking_number');
    }
}
