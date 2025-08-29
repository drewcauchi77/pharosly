<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Password;

final readonly class ForgotPasswordAction
{
    /**
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
