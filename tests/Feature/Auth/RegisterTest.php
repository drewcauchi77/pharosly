<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\{get};

test('register page renders correct inertia component', function () {
    $response = get(route('register'));

    $response->assertInertia(function (AssertableInertia $page) {
        $page->component('Auth/Register');
    });
});

test('required error messages are shown when fields are empty', function () {
    $this->from(route('register'))
        ->post(route('register'), [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ])
        ->assertRedirect(route('register'));

    $this->assertGuest();

    $this->get(route('register'))
        ->assertSee('The name field is required.')
        ->assertSee('The email field is required.')
        ->assertSee('The password field is required.');
});

test('user cannot register if email already exists', function () {
    User::factory()->create([
        'email' => 'test@example.com'
    ]);

    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('register'));

    $this->get(route('register'))
        ->assertSee('The email has already been taken.');
});

test('user cannot register if password is not confirmed correctly', function () {
    $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'wrong-password',
        ])
        ->assertRedirect(route('register'));

    $this->assertGuest();

    $this->get(route('register'))
        ->assertSee('The password field confirmation does not match.');
});

test('user can register successfully', function () {
    $response = $this->from(route('register'))
        ->post(route('register'), [
            'name' => 'Test Name',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ])
        ->assertRedirect(route('home'));

    $this->assertAuthenticatedAs(Auth::user());

    $response->assertRedirect(route('home'))
        ->assertSessionHasNoErrors();
});
