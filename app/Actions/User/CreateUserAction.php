<?php

namespace App\Actions\User;

use App\Models\User;

final class CreateUserAction
{
    /**
     * @param array<string> $data
     * @return User
     */
    public function handle(array $data): User
    {
        return User::query()->create($data);
    }
}
