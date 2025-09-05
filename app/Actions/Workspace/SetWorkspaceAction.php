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
     * @return Workspace
     */
    public function handle(): Workspace
    {
        /** @var User $user */
        $user = Auth::user();

        $workspaces = $user->workspaces();
        $mainWorkspaceId = $workspaces->oldest()->value('id') ?? null;
        $this->switch($mainWorkspaceId);

        return Workspace::query()
            ->where('id', $mainWorkspaceId)->firstOrFail();
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
