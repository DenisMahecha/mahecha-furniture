<?php

use Illuminate\Support\Facades\Route;

test('registration screen is not publicly available', function () {
    $response = $this->get('/register');

    $response->assertNotFound();
});

test('registration remains disabled for new users', function () {
    expect(Route::has('register'))->toBeFalse();
});
