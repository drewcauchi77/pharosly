<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateUserAction;
use App\Actions\Workspace\CreateWorkspaceAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterUserRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class RegisterController extends Controller
{
    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * @param RegisterUserRequest $request
     * @param CreateUserAction $createUser
     * @param CreateWorkspaceAction $createWorkspace
     * @param SetWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function store(
        RegisterUserRequest $request,
        CreateUserAction $createUser,
        CreateWorkspaceAction $createWorkspace,
        SetWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        $user = $createUser->handle($request->validated());
        $createWorkspace->handle($request->validated(), $user);
        Auth::login($user);
        $setWorkspace->handle();

        return redirect()->route('dashboard')->with([
            'success' => [
                'title' => 'Registration Successful',
                'description' => 'Your account has been created. You are now logged in.'
            ]
        ]);
    }
}
