<?php

namespace App\Actions\Episode;

use App\Models\Episode;
use Illuminate\Support\Facades\Session;

final class CreateEpisodeAction
{
    /**
     * @param array<mixed> $data
     * @return Episode
     */
    public function handle(array $data): Episode
    {
        $data = array_merge($data, [
            'workspace_id' => Session::get('workspace_id'),
        ]);

        return Episode::query()->create($data);
    }
}
