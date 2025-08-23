<?php

namespace App\Http\Controllers;

use App\Actions\Episode\CreateEpisodeAction;
use App\Http\Requests\Episode\StoreEpisodeRequest;
use App\Http\Requests\Episode\UpdateEpisodeRequest;
use App\Models\Episode;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;

class EpisodeController extends Controller
{
    /**
     * Display the listing of the episodes.
     *
     * @return Response
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Episode::class);

        // Determine the current workspace from session; if missing/invalid, fall back to oldest
        $user = Auth::user();
        $workspaceId = session('workspace_id');

        // Ensure the session workspace belongs to the user; otherwise pick the oldest
        $ownsWorkspace = $workspaceId ? $user->workspaces()->where('id', $workspaceId)->exists() : false;
        if (!$ownsWorkspace) {
            $workspaceId = $user->workspaces()->oldest()->value('id');
            if ($workspaceId) {
                session(['workspace_id' => $workspaceId]);
            }
        }

        $query = Episode::query()
            ->select('id', 'title', DB::raw("substr(description, 1, 60) || '...' as description"), 'updated_at');

        if ($workspaceId) {
            $query->where('workspace_id', $workspaceId);
        } else {
            // No workspace available; ensure empty result set while keeping paginator structure
            $query->whereRaw('1 = 0');
        }

        $episodes = $query->paginate(15);

        return Inertia::render('Episode/EpisodeList', [
            'episodes' => $episodes,
        ]);
    }

    /**
     * Show the form for creating a new episode.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Episode/CreateEpisode');
    }

    /**
     * Store a newly created episode in storage.
     *
     * @param StoreEpisodeRequest $request
     * @param CreateEpisodeAction $createEpisode
     * @return RedirectResponse
     */
    public function store(
        StoreEpisodeRequest $request,
        CreateEpisodeAction $createEpisode
    ): RedirectResponse
    {
        $episode = $createEpisode->handle($request->validated());
        return redirect()->route('episodes.show', $episode);
    }

    /**
     * Display the specified episode.
     *
     * @param Episode $episode
     * @return Response
     */
    public function show(Episode $episode): Response
    {
        Gate::authorize('view', $episode);

        return Inertia::render('Episode/ShowEpisode', [
            'episode' => $episode
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Episode $episode): void
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEpisodeRequest $request, Episode $episode): void
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Episode $episode): void
    {
        //
    }
}
