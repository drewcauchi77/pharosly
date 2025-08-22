<?php

namespace App\Actions\Workspace;

use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;

final class CreateWorkspaceAction
{
    /**
     * Handles workspace creation.
     *
     * @param array<string> $data
     * @param User|null $user
     * @return void
     */
    public function handle(array $data, ?User $user = null): void
    {
        Workspace::query()->create([
            'name' => $data['workspace'],
            'user_id' => $user ? $user->id : Auth::user()->id,
        ]);
    }
}
