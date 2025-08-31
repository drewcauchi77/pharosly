<?php

namespace App\Http\Controllers;

use App\Actions\Workspace\CreateWorkspaceAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\DTO\WorkspaceDTO;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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

        $createWorkspace->handle($workspaceDTO);

        return redirect()->route('episodes.index')->with('notification', [
            'title' => 'Workspace created',
            'description' => 'Workspace {name} successfully created.'
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
     * @param Workspace $workspace
     * @return void
     */
    public function destroy(Workspace $workspace): void
    {
        //
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
