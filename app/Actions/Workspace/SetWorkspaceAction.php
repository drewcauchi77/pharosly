<?php

namespace App\Actions\Workspace;

use App\Actions\Auth\LogoutUserAction;
use App\Models\User;
use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final readonly class SetWorkspaceAction
{
    /**
     * @return Workspace|null
     */
    public function handle(): Workspace|null
    {
        /** @var User $user */
        $user = Auth::user();

        $oldestWorkspace = $user->workspaces()->oldest()->first();

        if ($oldestWorkspace)
        {
            $this->switch($oldestWorkspace->id);
            return $oldestWorkspace;
        }

        return null;
    }

    /**
     * @param int|null $workspaceId
     * @return void
     */
    public function switch(?int $workspaceId): void
    {
        Session::put('workspace_id', $workspaceId);
    }
}
