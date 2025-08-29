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
     * @return Response
     */
    public function index(): Response
    {
        Gate::authorize('viewAny', Episode::class);

        return Inertia::render('Episode/EpisodeList', [
            'episodes' => Episode::query()
                ->select('id', 'title', DB::raw("substr(description, 1, 60) || '...' as description"), 'updated_at')
                ->where('workspace_id', session('workspace_id'))
                ->paginate(15)
        ]);
    }

    /**
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('Episode/CreateEpisode');
    }

    /**
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

        return redirect()->route('episodes.show', $episode)->with([
            'success' => [
                'title' => 'Episode Created',
                'description' => 'Your new episode is now successfully created.'
            ]
        ]);
    }

    /**
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
     * @param Episode $episode
     * @return void
     */
    public function edit(Episode $episode): void
    {
        //
    }

    /**
     * @param UpdateEpisodeRequest $request
     * @param Episode $episode
     * @return void
     */
    public function update(UpdateEpisodeRequest $request, Episode $episode): void
    {
        //
    }

    /**
     * @param Episode $episode
     * @return void
     */
    public function destroy(Episode $episode): void
    {
        //
    }
}
