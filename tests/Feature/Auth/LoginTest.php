<?php

use function Pest\Laravel\{get};

test('login page renders correct inertia component', function () {
    $response = get(route('login.create'));

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('Auth/Login'));
});
