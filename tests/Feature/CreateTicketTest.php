<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

uses(TestCase::class, RefreshDatabase::class);

it('returns a successful response', function () {
    // Create a user with the necessary permissions
    $user = User::factory()->create();
    $user->assignRole('admin'); // Ensure the user has the 'admin' role or necessary permissions

    // Act as the created user
    $this->actingAs($user);

    // Make a request to the Filament dashboard
    $response = $this->get('/admin'); // Adjust the URL to match your Filament dashboard URL

    // Assert that the response status is 200
    $response->assertStatus(200);
});
