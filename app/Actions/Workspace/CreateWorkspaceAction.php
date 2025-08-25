<?php

namespace App\Actions\Workspace;

use App\Actions\Auth\LogoutUserAction;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use InvalidArgumentException;

final class CreateWorkspaceAction
{
    /**
     * Handles workspace creation.
     *
     * @param array<string, mixed> $data
     * @param User|null $user
     * @return void
     */
    public function handle(array $data, ?User $user = null): void
    {
        $name = $data['workspace'] ?? $data['name'] ?? null;
        $name = is_string($name) ? trim($name) : null;

        $user = $user ?? Auth::user();

        if (!$user instanceof User) {
            (new LogoutUserAction)->handle();
            return;
        }

        Workspace::query()->create([
            'name' => $name,
            'user_id' => $user->id,
        ]);
    }
}
