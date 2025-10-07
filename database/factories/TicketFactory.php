<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'event_id' => Event::factory(),
            'type' => fake()->randomElement(['Standard', 'VIP', 'General Admission']),
            'price' => fake()->randomFloat(2, 15, 250),
            'quantity' => fake()->numberBetween(50, 500),
        ];
    }
}