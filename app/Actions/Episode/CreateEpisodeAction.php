<?php

namespace App\Actions\Episode;

use App\Models\Episode;

final class CreateEpisodeAction
{
    /**
     * @param array<mixed> $data
     * @return Episode
     */
    public function handle(array $data): Episode
    {
        return Episode::query()->create($data);
    }
}
