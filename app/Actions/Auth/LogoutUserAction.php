<?php

namespace App\Actions\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

final class LogoutUserAction
{
    /**
     * @return void
     */
    public function handle(): void
    {
        Auth::logout();

        Session::forget('workspace_id');
        Session::invalidate();
        Session::regenerateToken();
    }
}
