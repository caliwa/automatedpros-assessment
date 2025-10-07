<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\Booking;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 2 Administradores
        User::factory()->create([
            'name' => 'Admin User 1',
            'email' => 'admin1@example.com',
            'role' => UserRole::ADMIN,
            'password' => Hash::make('admin123'),
        ]);

        User::factory()->create([
            'name' => 'Admin User 2',
            'email' => 'admin2@example.com',
            'role' => UserRole::ADMIN,
            'password' => Hash::make('admin123'),
        ]);
        
        $organizers = User::factory(3)->create(['role' => UserRole::ORGANIZER]);
        $customers = User::factory(10)->create(['role' => UserRole::CUSTOMER]);

        $events = Event::factory(5)->make()->each(function ($event) use ($organizers) {
            $event->created_by = $organizers->random()->id;
            $event->save();
        });

        $events->each(function ($event) {
            Ticket::factory()->create(['event_id' => $event->id, 'type' => 'Standard', 'quantity' => 100]);
            Ticket::factory()->create(['event_id' => $event->id, 'type' => 'VIP', 'quantity' => 20]);
            Ticket::factory()->create(['event_id' => $event->id, 'type' => 'Early Bird', 'quantity' => 50]);
        });

        $tickets = Ticket::all();
        $customers->each(function ($customer) use ($tickets) {
              Booking::factory(2)->create([
                  'user_id' => $customer->id,
                  'ticket_id' => $tickets->random()->id,
              ]);
        });
    }
}