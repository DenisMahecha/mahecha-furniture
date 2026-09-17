<?php

use App\Models\CashCollection;
use App\Models\User;

test('guests are redirected to the login page', function () {
    $response = $this->get('/dashboard');
    $response->assertRedirect('/login');
});

test('authenticated users can visit the dashboard', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard');
    $response->assertStatus(200);
});

test('dashboard shows cash collection summary for the business', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    CashCollection::create([
        'customer_name' => 'Amina Juma',
        'amount' => 250000,
        'received_at' => today(),
        'notes' => 'COD for dining set',
    ]);

    $response = $this->get('/dashboard');

    $response->assertStatus(200)
        ->assertSee('TZS 250,000')
        ->assertSee('Malipo ya COD');
});
