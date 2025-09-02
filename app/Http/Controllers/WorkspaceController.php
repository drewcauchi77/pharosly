<?php

namespace App\Http\Controllers;

use App\Actions\Workspace\CreateWorkspaceAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\DTO\WorkspaceDTO;
use App\Http\Requests\Workspace\DestroyWorkspaceRequest;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
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
            $request->validated()['name'],
            $user->id
        );

        $workspace = $createWorkspace->handle($workspaceDTO);

        return redirect()->route('workspaces.index')->with('notification', [
            'title' => 'Workspace created',
            'description' => "Workspace '{$workspace->name}' successfully created."
        ]);
    }

    /**
     * @param Workspace $workspace
     * @return void
     */
    public function show(Workspace $workspace): void
    {
        //
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
     * @return RedirectResponse
     */
    public function destroy(
        DestroyWorkspaceRequest $request,
        Workspace $workspace
    ): RedirectResponse
    {
        // Check the user password on deletion
        if (!Hash::check($request->validated('password'), Auth::user()->password))
        {
            return redirect()->back()->withErrors(['password' => 'Wrong password']);
        }

        if (Auth::user()->workspaces()->count() == 1)
        {
            return redirect()->back()->withErrors(['minimum_workspaces' => 'You are required to have at least 1 workspace under your account.']);
        }

        Workspace::destroy($workspace->id);

        (new SetWorkspaceAction())->handle();

        return redirect()->route('workspaces.index')->with('notification', [
            'title' => 'Deletion Successful',
            'description' => "Workspace '{$workspace->name}' has been successfully deleted."
        ]);
    }

    /**
     * @param Workspace $workspace
     * @param SetWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function switch(
        Workspace $workspace,
        SetWorkspaceAction $setWorkspace
    ): RedirectResponse
    {
        Gate::authorize('switch', $workspace);
        $setWorkspace->switch($workspace->id);

        return redirect()->route('episodes.index')->with('notification', [
            'title' => 'Workspace switched',
            'description' => "Workspace {name} successfully switched."
        ]);
    }
}
