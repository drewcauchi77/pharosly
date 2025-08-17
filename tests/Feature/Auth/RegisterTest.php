<?php

use function Pest\Laravel\{get};

test('register page renders correct inertia component', function () {
    $response = get(route('register'));

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('Auth/Register'));
});
