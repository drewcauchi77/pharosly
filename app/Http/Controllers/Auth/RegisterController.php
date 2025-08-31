<?php

namespace App\Http\Controllers\Auth;

use App\Actions\User\CreateUserAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\DTO\UserDTO;
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
     * @param SetWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function store(
        RegisterUserRequest $request,
        CreateUserAction $createUser,
        SetWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        $userDTO = new UserDTO(
            $request->validated()['email'],
            $request->validated()['password']
        );

        $user = $createUser->handle($userDTO, $request->validated()['workspace']);

        Auth::login($user);
        $setWorkspace->handle();

        return redirect()->route('dashboard')->with('notification', [
            'title' => 'Registration Successful',
            'description' => 'Your account has been created. You are now logged in.'
        ]);
    }
}
