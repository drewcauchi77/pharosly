<?php

namespace App\Actions\Workspace;

use App\Actions\Auth\LogoutUserAction;
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
        $mainWorkspaceId = Auth::user()->workspaces()->oldest()->value('id');

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
