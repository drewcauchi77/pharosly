<?php

namespace App\Http\Controllers;

use App\Actions\Workspace\CreateWorkspaceAction;
use App\Actions\Workspace\SetWorkspaceAction;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class WorkspaceController extends Controller
{
    /**
     * Display the listing of the workspaces.
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Workspace/WorkspaceList', [
            'workspaces' => Workspace::query()
                ->where('user_id', Auth::user()->id)
                ->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Workspace/CreateWorkspace');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreWorkspaceRequest $request
     * @param CreateWorkspaceAction $createWorkspace
     * @return RedirectResponse
     */
    public function store(
        StoreWorkspaceRequest $request,
        CreateWorkspaceAction $createWorkspace
    ): RedirectResponse
    {
        $createWorkspace->handle($request->validated());
        return redirect()->route('workspaces.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Workspace $workspace): void
    {
        //
    }

    /**
     * Show the form for editing the specified workspace.
     *
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
     * Update the specified resource in storage.
     */
    public function update(UpdateWorkspaceRequest $request, Workspace $workspace): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Workspace $workspace): void
    {
        //
    }

    /**
     * Switch the current session workspace to the provided workspace.
     *
     * @param Request $request
     * @param Workspace $workspace
     * @param SetWorkspaceAction $setWorkspace
     * @return RedirectResponse
     */
    public function switch(Request $request, Workspace $workspace, SetWorkspaceAction $setWorkspace): RedirectResponse
    {
        Gate::authorize('switch', $workspace);
        $setWorkspace->switch($workspace->id);

        return redirect()->route('episodes.index')->with('status', 'Workspace switched');
    }
}
