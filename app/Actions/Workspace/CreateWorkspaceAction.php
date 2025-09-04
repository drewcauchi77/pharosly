<?php

namespace App\Actions\Workspace;

use App\DTO\WorkspaceDTO;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

final readonly class CreateWorkspaceAction
{
    /**
     * @param WorkspaceDTO $attributes
     * @return Workspace
     */
    public function handle(WorkspaceDTO $attributes): Workspace
    {
        return DB::transaction(function () use ($attributes) {
            $workspace = Workspace::query()
                ->create($attributes->toArray());

            /** @var User $user */
            $user = Auth::user();

            if ($user->workspaces()->count() == 1)
            {
                (new SetWorkspaceAction())->switch($workspace->id);
            }

            return $workspace;
        });
    }
}
