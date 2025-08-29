<?php

namespace App\Actions\Workspace;

use App\DTO\WorkspaceDTO;
use App\Models\Workspace;
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
            return Workspace::query()
                ->create($attributes->toArray());
        });
    }
}
