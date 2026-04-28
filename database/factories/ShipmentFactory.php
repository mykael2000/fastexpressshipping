<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ShipmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tracking_number' => strtoupper($this->faker->bothify('FES##########')),
            'status' => $this->faker->randomElement(['created', 'picked_up', 'in_transit', 'out_for_delivery', 'delivered']),
            'origin' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'destination' => $this->faker->city() . ', ' . $this->faker->stateAbbr(),
            'sender_name' => $this->faker->name(),
            'sender_email' => $this->faker->safeEmail(),
            'sender_address' => $this->faker->address(),
            'sender_phone' => $this->faker->phoneNumber(),
            'recipient_name' => $this->faker->name(),
            'recipient_email' => $this->faker->safeEmail(),
            'recipient_phone' => $this->faker->phoneNumber(),
            'eta' => $this->faker->dateTimeBetween('now', '+2 weeks'),
            'shipped_date' => $this->faker->dateTimeBetween('-1 week', 'now'),
            'service_level' => $this->faker->randomElement(['standard', 'express', 'overnight']),
            'amount' => $this->faker->randomFloat(2, 10, 500),
            'payment_status' => 'unpaid',
            'paid_at' => null,
            'notify_email' => true,
            'notify_sms' => false,
        ];
    }
}
