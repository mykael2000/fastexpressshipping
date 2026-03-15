<?php
namespace Tests\Feature;

use App\Models\Shipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminShipmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    private function admin(): User
    {
        return User::factory()->create([
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);
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

    public function test_admin_can_create_shipment_with_new_fields(): void
    {
        $response = $this->actingAs($this->admin())
            ->post('/admin/shipments', [
                'tracking_number' => 'ADMIN002',
                'status' => 'created',
                'origin' => 'Lagos, NG',
                'destination' => 'Abuja, NG',
                'recipient_name' => 'Jane Smith',
                'recipient_email' => 'jane@example.com',
                'service_level' => 'express',
                'payment_mode' => 'bank',
                'weight_kg' => '2.50',
                'remark' => 'Cost: $15. Handle with care.',
                'notify_email' => '1',
                'notify_sms' => '0',
            ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('shipments', [
            'tracking_number' => 'ADMIN002',
            'payment_mode' => 'bank',
            'remark' => 'Cost: $15. Handle with care.',
        ]);

        $shipment = Shipment::where('tracking_number', 'ADMIN002')->first();
        $this->assertEquals('2.50', $shipment->weight_kg);
    }

    public function test_shipment_weight_kg_must_be_non_negative(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/shipments', [
                'tracking_number' => 'ADMIN003',
                'status' => 'created',
                'origin' => 'New York, NY',
                'destination' => 'LA',
                'recipient_name' => 'Test',
                'service_level' => 'standard',
                'weight_kg' => '-1',
            ])
            ->assertSessionHasErrors('weight_kg');
    }

    public function test_shipment_payment_mode_must_be_valid(): void
    {
        $this->actingAs($this->admin())
            ->post('/admin/shipments', [
                'tracking_number' => 'ADMIN004',
                'status' => 'created',
                'origin' => 'New York, NY',
                'destination' => 'LA',
                'recipient_name' => 'Test',
                'service_level' => 'standard',
                'payment_mode' => 'invalid_mode',
            ])
            ->assertSessionHasErrors('payment_mode');
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

    public function test_admin_can_mark_shipment_as_paid(): void
    {
        $shipment = Shipment::factory()->create(['payment_status' => 'unpaid']);

        $this->actingAs($this->admin())
            ->post("/admin/shipments/{$shipment->id}/mark-paid")
            ->assertRedirect();

        $shipment->refresh();
        $this->assertEquals('paid', $shipment->payment_status);
        $this->assertNotNull($shipment->paid_at);
    }

    public function test_admin_can_mark_shipment_as_unpaid(): void
    {
        $shipment = Shipment::factory()->create([
            'payment_status' => 'paid',
            'paid_at' => now(),
        ]);

        $this->actingAs($this->admin())
            ->post("/admin/shipments/{$shipment->id}/mark-unpaid")
            ->assertRedirect();

        $shipment->refresh();
        $this->assertEquals('unpaid', $shipment->payment_status);
        $this->assertNull($shipment->paid_at);
    }

    public function test_guest_cannot_mark_shipment_as_paid(): void
    {
        $shipment = Shipment::factory()->create(['payment_status' => 'unpaid']);

        $this->post("/admin/shipments/{$shipment->id}/mark-paid")
            ->assertRedirect('/login');
    }
}
