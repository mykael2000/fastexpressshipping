<?php
namespace Tests\Feature;

use App\Models\Shipment;
use App\Models\TrackingEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TrackingTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutVite();
    }

    public function test_tracking_homepage_loads(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Fast Express Shipping');
    }

    public function test_valid_tracking_number_shows_result(): void
    {
        $shipment = Shipment::factory()->create([
            'tracking_number' => 'TESTTRACK001',
            'status' => 'in_transit',
        ]);

        $response = $this->post('/track', ['tracking_number' => 'TESTTRACK001']);
        $response->assertStatus(200);
        $response->assertSee('TESTTRACK001');
        $response->assertSee($shipment->statusLabel());
    }

    public function test_invalid_tracking_number_shows_error(): void
    {
        $response = $this->post('/track', ['tracking_number' => 'NOTFOUND999']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('tracking_number');
    }

    public function test_tracking_form_validates_format(): void
    {
        $response = $this->post('/track', ['tracking_number' => 'bad number!@#']);
        $response->assertStatus(302);
        $response->assertSessionHasErrors('tracking_number');
    }

    public function test_tracking_result_shows_events(): void
    {
        $shipment = Shipment::factory()->create(['tracking_number' => 'EVENTTRACK001']);
        TrackingEvent::factory()->create([
            'shipment_id' => $shipment->id,
            'event_type' => 'transit',
            'description' => 'Package arrived at sorting facility',
        ]);

        $response = $this->get('/track/EVENTTRACK001');
        $response->assertStatus(200);
        $response->assertSee('Package arrived at sorting facility');
    }

    public function test_tracking_result_shows_new_shipment_fields(): void
    {
        $shipment = Shipment::factory()->create([
            'tracking_number' => 'NEWFIELDS001',
            'payment_mode' => 'cash',
            'weight_kg' => '3.75',
            'remark' => 'Fragile item - cost $20',
        ]);

        $response = $this->get('/track/NEWFIELDS001');
        $response->assertStatus(200);
        $response->assertSee('Cash');
        $response->assertSee('3.75 kg');
        $response->assertSee('Fragile item - cost $20');
    }

    public function test_tracking_result_shows_office_address(): void
    {
        \App\Models\SiteSetting::updateOrCreate(
            ['key' => 'contact_address'],
            ['value' => '123 Logistics Way, Atlanta, GA 30301', 'group' => 'general']
        );

        $shipment = Shipment::factory()->create(['tracking_number' => 'ADDRTEST001']);

        $response = $this->get('/track/ADDRTEST001');
        $response->assertStatus(200);
        $response->assertSee('123 Logistics Way, Atlanta, GA 30301');
    }

    public function test_tracking_result_handles_missing_new_fields(): void
    {
        $shipment = Shipment::factory()->create([
            'tracking_number' => 'NULLFIELDS001',
            'payment_mode' => null,
            'weight_kg' => null,
            'remark' => null,
        ]);

        $response = $this->get('/track/NULLFIELDS001');
        $response->assertStatus(200);
        // Page still renders without errors; dashes shown for missing fields
        $response->assertSee('—');
    }
}
