<?php

use App\Enums\UserRole;
use App\Models\User;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\postJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\actingAs;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('a user can register', function () {
    postJson('/api/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
    ->assertStatus(201)
    ->assertJsonPath('data.access_token', fn ($token) => !empty($token));

    assertDatabaseHas('users', ['email' => 'test@example.com']);
});

test('a user can login and get a token', function () {
    $user = User::factory()->create(['password' => bcrypt('password')]);

    postJson('/api/login', [
        'email' => $user->email,
        'password' => 'password',
    ])
    ->assertOk()
    ->assertJsonPath('data.access_token', fn ($token) => !empty($token));
});

test('an authenticated user can fetch their details', function () {
    $user = User::factory()->create(['role' => UserRole::CUSTOMER]);

    actingAs($user)
        ->getJson('/api/me')
        ->assertOk()
        ->assertJsonPath('data.email', $user->email);
});