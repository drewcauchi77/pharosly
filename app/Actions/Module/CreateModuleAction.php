<?php

namespace App\Actions\Module;

use App\Models\Module;

final class CreateModuleAction
{
    /**
     * @param array<mixed> $data
     * @return Module
     */
    public function handle(array $data): Module
    {
        return Module::query()->create($data);
    }
}
