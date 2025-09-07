<?php

namespace App\Actions\Workspace;

use App\Models\Workspace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

final readonly class DestroyWorkspaceAction
{
    /**
     * @var Workspace|null
     */
    private ?Workspace $workspace;

    /**
     * @param Workspace|null $workspace
     */
    public function __construct(?Workspace $workspace = null)
    {
        $this->workspace = $workspace;
    }

    /**
     * @param Workspace $workspace
     * @return self
     */
    public function handle(Workspace $workspace): self
    {
        DB::transaction(function () use ($workspace) {
            $workspace->delete();
        });

        return new self($workspace);
    }

    /**
     * @return array<int, array{
     *     title: string,
     *     description: string
     * }>
     */
    public function withNotifications(): array
    {
        if (!$this->workspace)
        {
            return [];
        }

        $notifications = [
            [
                'title' => 'Deletion Successful',
                'description' => "Workspace '{$this->workspace->name}' has been successfully deleted."
            ]
        ];

        if ($this->workspace->id === Session::get('workspace_id'))
        {
            $switchedWorkspace = (new SwitchWorkspaceAction())->handle();

            if ($switchedWorkspace)
            {
                $notifications[] = [
                    'title' => 'Workspace switched',
                    'description' => "Switched to workspace '{$switchedWorkspace->name}' successfully."
                ];
            }
        }

        return $notifications;
    }
}
