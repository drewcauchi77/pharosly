<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Inertia\Response;

class ResetPasswordController extends Controller
{
    /**
     * Show the reset password form.
     *
     * @param Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        return Inertia::render('Auth/ResetPassword', [
            'email' => $request->email ?? null,
            'token' => $request->route('token')
        ]);
    }

    /**
     * Resetting the password through the email and token.
     *
     * @param ResetPasswordRequest $request
     * @param ResetPasswordAction $resetPassword
     * @return RedirectResponse
     */
    public function store(
        ResetPasswordRequest $request,
        ResetPasswordAction $resetPassword
    ): RedirectResponse
    {
        $request->validated();

        $status = $resetPassword->handle(
            $request->only('email', 'password', 'password_confirmation', 'token')
        );

        return $status === Password::PasswordReset
            ? redirect()->route('login')->with([
                'success' => [
                    'title' => 'Password Reset',
                    'description' => 'Your password has been updated. Please log in with your new credentials.'
                ]
            ])
            : redirect()->back()->withErrors(['email' => [__($status)]]);
    }
}
