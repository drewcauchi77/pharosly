<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;

final class ForgotPasswordAction
{
    /**
     * Sends a reset link to the user;
     *
     * @param array<mixed> $data
     * @return string
     */
    public function handle(array $data): string
    {
        return Password::sendResetLink(
            $data
        );
    }
}
