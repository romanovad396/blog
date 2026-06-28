<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class EnsureAdminCanAccessDashboard
{
    public function handle(Login $event): void
    {
        if (! $event->user->hasAccess('platform.index')) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => ['В админку может войти только администратор.'],
            ]);
        }
    }
}
