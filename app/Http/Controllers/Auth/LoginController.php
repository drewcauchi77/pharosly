<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutUserAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * Show the login form.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * Login the user.
     *
     * @param LoginUserRequest $request
     * @param SetWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function store(
        LoginUserRequest $request,
        SetWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        if (Auth::attempt($request->validated(), $request->boolean('remember')))
        {
            $request->session()->regenerate();
            $setWorkspace->handle();

            return redirect()->route('dashboard')->with([
                'success' => [
                    'title' => 'Login success',
                    'description' => 'Welcome back! You are now logged in.'
                ]
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Logout the user.
     *
     * @param LogoutUserAction $logoutUser
     * @return RedirectResponse
     */
    public function destroy(LogoutUserAction $logoutUser): RedirectResponse
    {
        $logoutUser->handle();
        return redirect()->route('login');
    }
}
