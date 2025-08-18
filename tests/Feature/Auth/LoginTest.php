<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\{from, get};

describe('Rendering', function() {
    test('login page renders the correct Inertia component', function () {
        get(route('login'))
            ->assertInertia(function (AssertableInertia $page) {
                $page->component('Auth/Login');
            });
    });
});

describe('Form', function() {
    test('user can login successfully if account exists and credentials are correct', function () {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        from(route('login'))
            ->post(route('login'), [
                'email' => 'test@example.com',
                'password' => 'password',
            ])
            ->assertRedirect(route('home'))
            ->assertSessionDoesntHaveErrors();

        expect(Auth::check())->toBeTrue()
            ->and(Auth::id())->toBe(1);
    });

    test('user cannot login if account does not exist', function () {
        from(route('login'))
            ->post(route('login'), [
                'email' => 'wrong-email@example.com',
                'password' => 'password',
            ])
            ->assertRedirect(route('login'));

        expect(Auth::check())->toBeFalse();

        get(route('login'))
            ->assertSee('The provided credentials do not match our records.');
    });

    test('user cannot login if password is incorrect', function () {
        User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        from(route('login'))
            ->post(route('login'), [
                'email' => 'test@example.com',
                'password' => 'wrong-password',
            ])
            ->assertRedirect(route('login'));

        expect(Auth::check())->toBeFalse();

        get(route('login'))
            ->assertSee('The provided credentials do not match our records.');
    });

    test('required error messages are shown if credentials are not provided', function () {
        from(route('login'))
            ->post(route('login'), [
                'email' => '',
                'password' => '',
            ])
            ->assertRedirect(route('login'));

        expect(Auth::check())->toBeFalse();

       get(route('login'))
            ->assertSee('The email field is required.')
            ->assertSee('The password field is required.');
    });

    test('remember me token is created when checkbox is ticked', function () {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password')
        ]);

        from(route('login'))
            ->post(route('login'), [
                'email' => 'test@example.com',
                'password' => 'password',
                'remember' => true,
            ])
            ->assertRedirect(route('home'))
            ->assertSessionDoesntHaveErrors();

        $user->refresh();

        expect(Auth::user()->getRememberToken())->not->toBeNull();
    });
});
