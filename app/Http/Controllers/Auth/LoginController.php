<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\LogoutUserAction;
use App\Actions\Workspace\SwitchWorkspaceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LoginController extends Controller
{
    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login');
    }

    /**
     * @param LoginUserRequest $request
     * @param SwitchWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function store(
        LoginUserRequest $request,
        SwitchWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        if (Auth::attempt($request->validated(), $request->boolean('remember')))
        {
            $request->session()->regenerate();
            $setWorkspace->handle();

            return redirect()->route('dashboard')->with('notification', [
                'title' => 'Logged In',
                'description' => 'You’re all set to continue.'
            ]);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * @param LogoutUserAction $logoutUser
     * @return RedirectResponse
     */
    public function destroy(LogoutUserAction $logoutUser): RedirectResponse
    {
        $logoutUser->handle();

        return redirect()->route('login')->with('notification', [
            'title' => 'Logged Out',
            'description' => 'You’ve been signed out successfully.'
        ]);
    }
}
