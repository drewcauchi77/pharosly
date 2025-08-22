<?php

namespace App\Http\Controllers;

use App\Actions\Workspace\CreateWorkspaceAction;
use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
     * @param CreateWorkspaceAction $workspaceAction
     * @return RedirectResponse
     */
    public function store(StoreWorkspaceRequest $request, CreateWorkspaceAction $workspaceAction): RedirectResponse
    {
        $workspaceAction->handle($request->validated());
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
     * Show the form for editing the specified resource.
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
     * This can be called from the frontend (VueJS) to change context.
     */
    public function switch(Request $request, Workspace $workspace): RedirectResponse
    {
        // Ensure the authenticated user owns this workspace
        if ($workspace->user_id !== Auth::id()) {
            abort(403);
        }

        // Store the selected workspace ID in the session
        $request->session()->put('workspace_id', $workspace->id);

        // Redirect back to previous page or dashboard
        return redirect()->route('episodes.index')->with('status', 'Workspace switched');
    }
}
