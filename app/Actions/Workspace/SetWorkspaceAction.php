<?php

namespace App\Actions\Workspace;

use App\Actions\Auth\LogoutUserAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final class SetWorkspaceAction
{
    /**
     * Handle the workspace change.
     *
     * @return void
     */
    public function handle(): void
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            (new LogoutUserAction)->handle();
            return;
        }

        $workspaces = $user->workspaces();
        $mainWorkspaceId = $workspaces->oldest()->value('id');

        if ($mainWorkspaceId) {
            $this->switch($mainWorkspaceId);
        } else {
            (new LogoutUserAction)->handle();
        }
    }

    /**
     * Changes the workspace.
     *
     * @param int $workspaceId
     * @return void
     */
    public function switch(int $workspaceId): void
    {
        Session::put('workspace_id', $workspaceId);
    }
}
