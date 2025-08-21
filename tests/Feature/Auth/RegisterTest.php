<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\{from, get};

describe('Component', function() {
    test('register page renders the correct Inertia component', function () {
        get(route('register'))
            ->assertInertia(function (AssertableInertia $page) {
                $page->component('Auth/Register');
            });
    });
});

describe('Form', function() {
    test('user can register successfully if email does not exist', function () {
        from(route('register'))
            ->post(route('register'), [
                'email' => 'test@example.com',
                'workspace' => 'My Workspace',
                'password' => 'password',
                'password_confirmation' => 'password',
            ])
            ->assertRedirect(route('dashboard'));

        expect(Auth::check())->toBeTrue()
            ->and(Auth::id())->toBe(1)
            ->and(Auth::user()->workspaces()->count())->toBe(1)
            ->and(Auth::user()->workspaces()->first()->id)->toBe(1);
    });

    test('user cannot register if email already exists', function () {
        User::factory()->create([
            'email' => 'test@example.com'
        ]);

       from(route('register'))
            ->post(route('register'), [
                'email' => 'test@example.com',
            ])
            ->assertRedirect(route('register'));

       get(route('register'))
            ->assertSee('The email has already been taken.');
    });

    test('user cannot register if password is not confirmed correctly', function () {
        from(route('register'))
            ->post(route('register'), [
                'password' => 'password',
                'password_confirmation' => 'wrong-password',
            ])
            ->assertRedirect(route('register'));

        expect(Auth::check())->toBeFalse();

        get(route('register'))
            ->assertSee('The password field confirmation does not match.');
    });

    test('required error messages are shown when fields are empty', function () {
        from(route('register'))
            ->post(route('register'), [
                'email' => '',
                'workspace' => '',
                'password' => '',
                'password_confirmation' => '',
            ])
            ->assertRedirect(route('register'));

        expect(Auth::check())->toBeFalse();

        get(route('register'))
            ->assertSee('The workspace field is required.')
            ->assertSee('The email field is required.')
            ->assertSee('The password field is required.');
    });
});








