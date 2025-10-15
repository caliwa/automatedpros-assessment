<?php

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;

uses(RefreshDatabase::class);

test('an organizer can create an event', function () {
    $organizer = User::factory()->create(['role' => UserRole::ORGANIZER]);

    $eventData = [
        'title' => 'New Awesome Event',
        'description' => 'A description for this awesome event.',
        'date' => now()->addMonth()->toDateTimeString(),
        'location' => 'Test Location',
    ];

    $response = actingAs($organizer)->postJson('/api/events', $eventData);

    $response->assertStatus(201);

    // assert that the event now exists in the database.
    assertDatabaseHas('events', [
        'title' => 'New Awesome Event',
    ]);
});

test('a customer cannot create an event', function () {
    $customer = User::factory()->create(['role' => UserRole::CUSTOMER]);

    $eventData = [
        'title' => 'An event a customer should not be able to create',
        'description' => 'Some description.',
        'date' => now()->addMonth()->toDateTimeString(),
        'location' => 'Some Location',
    ];

    $response = actingAs($customer)->postJson('/api/events', $eventData);

    $response->assertStatus(403);
});