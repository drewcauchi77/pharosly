<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * Show the register form.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * Create a new user account.
     *
     * @param RegisterUserRequest $request
     * @param CreateUser $action
     * @return RedirectResponse
     */
    public function store(RegisterUserRequest $request, CreateUser $action): RedirectResponse
    {
        Auth::login($action->handle($request->validated()));
        return redirect()->route('home');
    }
}
