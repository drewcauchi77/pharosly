<?php

namespace App\Http\Controllers;

use App\Actions\Auth\CheckPasswordAction;
use App\Actions\Workspace\CreateWorkspaceAction;
use App\Actions\Workspace\DestroyWorkspaceAction;
use App\Actions\Workspace\SwitchWorkspaceAction;
use App\DTO\WorkspaceDTO;
use App\Http\Requests\Workspace\DestroyWorkspaceRequest;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\SwitchWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\User;
use App\Models\Workspace;
use Hamcrest\Core\Set;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Inertia\Response;

class WorkspaceController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        /** @var User $user */
        $user = Auth::user();

        return Inertia::render('Workspace/WorkspaceList', [
            'workspaces' => Workspace::query()
                ->where('user_id', $user->id)
                ->paginate(15)
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Workspace/CreateWorkspace');
    }

    /**
     * @param StoreWorkspaceRequest $request
     * @param CreateWorkspaceAction $createWorkspace
     * @return RedirectResponse
     */
    public function store(
        StoreWorkspaceRequest $request,
        CreateWorkspaceAction $createWorkspace
    ): RedirectResponse
    {
        /** @var User $user */
        $user = Auth::user();

        $workspaceDTO = new WorkspaceDTO(
            $request->validated('name'),
            $request->validated('labels'),
            $request->validated('subdomain'),
            $request->validated('domain'),
            $request->validated('path'),
            $user->id
        );

        $workspace = $createWorkspace->handle($workspaceDTO);

        return redirect()->route('workspaces.edit', $workspace)->with('notification', [
            'title' => 'Workspace created',
            'description' => "Workspace '{$workspace->name}' successfully created."
        ]);
    }

    /**
     * @param Workspace $workspace
     * @return Response
     */
    public function edit(Workspace $workspace): Response
    {
        return Inertia::render('Workspace/EditWorkspace', [
            'workspace' => $workspace
        ]);
    }

    /**
     * @param UpdateWorkspaceRequest $request
     * @param Workspace $workspace
     * @return void
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace): void
    {
        //
    }

    /**
     * @param DestroyWorkspaceRequest $request
     * @param Workspace $workspace
     * @param CheckPasswordAction $checkPassword
     * @param DestroyWorkspaceAction $destroyWorkspace
     * @return RedirectResponse
     */
    public function destroy(
        DestroyWorkspaceRequest $request,
        Workspace $workspace,
        CheckPasswordAction $checkPassword,
        DestroyWorkspaceAction $destroyWorkspace
    ): RedirectResponse
    {
        if (!$checkPassword->handle($request->validated('password')))
        {
            return redirect()->back()->withErrors([
                'password' => 'Password is incorrect - please try again.'
            ]);
        }

        $notifications = $destroyWorkspace->handle($workspace)->withNotifications();

        return redirect()->back()->with('notification', $notifications);
    }

    /**
     * @param SwitchWorkspaceRequest $request
     * @param Workspace $workspace
     * @param SwitchWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function switch(
        SwitchWorkspaceRequest $request,
        Workspace $workspace,
        SwitchWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        $setWorkspace->switch($workspace->id);

        return redirect()->back()->with('notification', [
            'title' => 'Workspace switched',
            'description' => "Switched to workspace '{$workspace->name}' successfully."
        ]);
    }
}
