<?php

namespace App\Http\Controllers;

use App\Http\Requests\Workspace\StoreWorkspaceRequest;
use App\Http\Requests\Workspace\UpdateWorkspaceRequest;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
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
     */
    public function create(): void
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWorkspaceRequest $request): void
    {
        //
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
    public function edit(Workspace $workspace): void
    {
        //
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
}
