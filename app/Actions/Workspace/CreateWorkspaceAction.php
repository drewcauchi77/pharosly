<?php

namespace App\Actions\Workspace;

use App\Models\User;
use App\Models\Workspace;

final class CreateWorkspaceAction
{
    /**
     * Handles workspace creation.
     *
     * @param array<string> $data
     * @param User $user
     * @return void
     */
    public function handle(array $data, User $user): void
    {
        Workspace::query()->create([
            'name' => $data['workspace'],
            'user_id' => $user->id,
        ]);
    }
}
