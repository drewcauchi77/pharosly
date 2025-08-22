<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateUserAction;
use App\Actions\Workspace\CreateWorkspaceAction;
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
     * @param CreateUserAction $userAction
     * @param CreateWorkspaceAction $workspaceAction
     * @return RedirectResponse
     */
    public function store(RegisterUserRequest $request, CreateUserAction $userAction, CreateWorkspaceAction $workspaceAction): RedirectResponse
    {
        $user = $userAction->handle($request->validated());
        $workspaceAction->handle($request->validated(), $user);

        Auth::login($user);

        // Set current workspace in session to the oldest workspace of the user (the one just created)
        $oldestWorkspaceId = Auth::user()->workspaces()->oldest()->value('id');
        if ($oldestWorkspaceId) {
            session(['workspace_id' => $oldestWorkspaceId]);
        } else {
            session()->forget('workspace_id');
        }

        return redirect()->route('dashboard');
    }
}
