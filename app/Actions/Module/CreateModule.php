<?php

namespace App\Actions\Module;

use App\Models\Module;

final class CreateModule
{
    /**
     * @param array $data
     * @return Module
     */
    public function handle(array $data): Module
    {
        return Module::query()->create($data);
    }
}
