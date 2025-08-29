<?php

namespace App\Actions\Episode;

use App\DTO\EpisodeDTO;
use App\Models\Episode;
use Illuminate\Support\Facades\DB;

final readonly class CreateEpisodeAction
{
    /**
     * @param EpisodeDTO $attributes
     * @return Episode
     */
    public function handle(EpisodeDTO $attributes): Episode
    {
        return DB::transaction(function () use ($attributes) {
            return Episode::query()
                ->create($attributes->toArray());
        });
    }
}
