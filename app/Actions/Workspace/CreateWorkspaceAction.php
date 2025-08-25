<?php

namespace App\Actions\Workspace;

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

        /**
         * TODO Junie - How should I handle the null check here? User is always going to be logged in because the route is being Auth middleware. In this case should I throw a 503? Isn't is useless due to the middleware?
         **/
        $user = !$user ? Auth::user() : $user;

        if ($user instanceof User) {
            Workspace::query()->create([
                'name' => $name,
                'user_id' => $user->id,
            ]);
        }
    }
}
