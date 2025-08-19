<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Inertia\Testing\AssertableInertia;
use function Pest\Laravel\{from, get};

describe('Component', function() {
    test('register page renders the correct Inertia component', function () {
        get(route('password.request'))
            ->assertInertia(function (AssertableInertia $page) {
                $page->component('Auth/ForgotPassword');
            });
    });
});

describe('Form', function() {
    test('user receives the forgot password email successfully and token is stored', function () {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'test@example.com'
        ]);

        from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'test@example.com',
            ])
            ->assertRedirect(route('password.request'));

        get(route('password.request'))
            ->assertSee('We have emailed your password reset link.');

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use ($user) {
                expect(DB::table('password_reset_tokens')
                        ->where('email', $user->email)
                        ->exists()
                )->toBeTrue();

                $hash = DB::table('password_reset_tokens')
                    ->where('email', $user->email)
                    ->value('token');

                expect($hash)->not->toBeNull()
                    ->and(Hash::check($notification->token, $hash))->toBeTrue()
                    ->and(Password::getRepository()->exists($user, $notification->token))->toBeTrue();

                return true;
            }
        );
    });

    test('user cannot receive the forgot password email if email does not exist', function () {
        from(route('password.request'))
            ->post(route('password.email'), [
                'email' => 'test@example.com',
            ])
            ->assertRedirect(route('password.request'));

        get(route('password.request'))
            ->assertSee("We can't find a user with that email address.");
    });

    test('required error message is shown when field is empty', function () {
        from(route('password.request'))
            ->post(route('password.email'), [
                'email' => '',
            ])
            ->assertRedirect(route('password.request'));

        get(route('password.request'))
            ->assertSee('The email field is required.');
    });
});
