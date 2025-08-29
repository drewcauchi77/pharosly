<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use Illuminate\Support\Facades\Password;
use Inertia\Inertia;
use Inertia\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ForgotPasswordController extends Controller
{
    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/ForgotPassword', [
            'status' => session('status')
        ]);
    }

    /**
     * @param ForgotPasswordRequest $request
     * @param ForgotPasswordAction $forgotPassword
     * @return RedirectResponse
     */
    public function store(
        ForgotPasswordRequest $request,
        ForgotPasswordAction $forgotPassword
    ): RedirectResponse
    {
        $request->validated();

        $status = $forgotPassword->handle(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? redirect()->back()->with(['status' => __($status)])
            : redirect()->back()->withErrors(['email' => __($status)]);
    }
}
