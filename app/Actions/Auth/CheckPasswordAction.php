<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

final readonly class CheckPasswordAction
{
    /**
     * @param string $password
     * @return bool
     */
    public function handle(string $password): bool
    {
        /** @var User $user */
        $user = Auth::user();

        return Hash::check($password, $user->password);
    }
}
