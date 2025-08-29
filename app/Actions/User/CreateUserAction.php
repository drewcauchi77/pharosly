<?php

namespace App\Actions\User;

use App\Actions\Workspace\CreateWorkspaceAction;
use App\DTO\UserDTO;
use App\DTO\WorkspaceDTO;
use App\Models\User;
use Illuminate\Support\Facades\DB;

final readonly class CreateUserAction
{
    /**
     * @param UserDTO $attributes
     * @param string $workspaceName
     * @return User
     */
    public function handle(UserDTO $attributes, string $workspaceName): User
    {
        return DB::transaction(function () use ($attributes, $workspaceName) {
            $user = User::query()
                ->create($attributes->toArray());

            $workspaceDTO = new WorkspaceDTO(
                $workspaceName,
                $user->id
            );

            (new CreateWorkspaceAction)->handle($workspaceDTO);

            return $user;
        });
    }
}
