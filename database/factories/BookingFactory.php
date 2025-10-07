<?php

namespace Database\Factories;

use App\Enums\BookingStatus;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(['role' => 'customer']),
            'ticket_id' => Ticket::factory(),
            'quantity' => fake()->numberBetween(1, 4),
            'status' => fake()->randomElement(BookingStatus::cases()),
        ];
    }
}