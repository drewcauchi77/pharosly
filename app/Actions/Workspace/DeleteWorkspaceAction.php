<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

final readonly class DeleteWorkspaceAction
{
    /**
     * @param int $id
     * @return void
     */
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            return Workspace::destroy($id);
        });
    }
}
