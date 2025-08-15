<?php

use App\Models\User;
use function Pest\Laravel\{get};

test('login page renders correct inertia component', function () {
    $response = get(route('login.create'));

    $response->assertStatus(200)
        ->assertInertia(fn ($page) => $page->component('Auth/Login'));
});

test('required error messages are shown when fields are empty', function () {
    $this->from(route('login.create'))
        ->post(route('login.store'), [
            'email' => '',
            'password' => '',
        ])
        ->assertRedirect(route('login.create'));

    $this->assertGuest();

    $this->get(route('login.create'))
        ->assertSee('The email field is required.')
        ->assertSee('The password field is required.');
});

test('user can login successfully if account exists and credentials are correct', function () {
    $user = User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password')
    ]);

    $response = $this->from(route('login.create'))
        ->post(route('login.store'), [
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

    $this->assertAuthenticatedAs($user);

    $response->assertRedirect(route('home'))
        ->assertSessionHasNoErrors();
});

test('user cannot login with a non-existing email', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->from(route('login.create'))
        ->post(route('login.store'), [
            'email' => 'wrong-email@example.com',
            'password' => 'password',
        ])
        ->assertRedirect(route('login.create'));

    $this->assertGuest();

    $this->get(route('login.create'))
        ->assertSee('The provided credentials do not match our records.');
});

test('user cannot login with an incorrect password', function () {
    User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
    ]);

    $this->from(route('login.create'))
        ->post(route('login.store'), [
            'email' => 'test@example.com',
            'password' => 'wrong-password',
        ])
        ->assertRedirect(route('login.create'));

    $this->assertGuest();

    $this->get(route('login.create'))
        ->assertSee('The provided credentials do not match our records.');
});
