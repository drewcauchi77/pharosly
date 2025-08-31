<?php

namespace App\Actions\Workspace;

use App\Actions\Auth\LogoutUserAction;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final readonly class SetWorkspaceAction
{
    /**
     * @return void
     */
    public function handle(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $workspaces = $user->workspaces();
        $mainWorkspaceId = $workspaces->oldest()->value('id');
        $this->switch($mainWorkspaceId);
    }

    /**
     * @param int $workspaceId
     * @return void
     */
    public function switch(int $workspaceId): void
    {
        abort(503);
        Session::put('workspace_id', $workspaceId);
    }
}
