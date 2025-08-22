<?php

namespace App\Http\Controllers\Auth;

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
     * @return RedirectResponse
     */
    public function store(LoginUserRequest $request): RedirectResponse
    {
        if (Auth::attempt($request->validated(), $request->boolean('remember')))
        {
            $request->session()->regenerate();

            // Set current workspace in session to the oldest workspace of the user
            $oldestWorkspaceId = Auth::user()->workspaces()->oldest()->value('id');
            if ($oldestWorkspaceId) {
                $request->session()->put('workspace_id', $oldestWorkspaceId);
            } else {
                // Ensure key exists (optional)
                $request->session()->forget('workspace_id');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Logout the user.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->forget('workspace_id');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
