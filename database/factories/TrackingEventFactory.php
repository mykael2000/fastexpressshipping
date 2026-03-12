<?php
namespace Database\Factories;

use App\Models\Shipment;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrackingEventFactory extends Factory
{
    public function definition(): array
    {
        return [
            'shipment_id' => Shipment::factory(),
            'occurred_at' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'location' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'event_type' => $this->faker->randomElement(['pickup', 'transit', 'out_for_delivery', 'delivered', 'info']),
            'description' => $this->faker->sentence(),
        ];
    }
}
