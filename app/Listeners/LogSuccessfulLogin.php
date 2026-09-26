<?php

namespace App\Listeners;

use App\LoginLog;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogSuccessfulLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Login $event)
    {
        // Cegah error jika user tidak ada
        if (!$event->user) {
            return;
        }

        LoginLog::create([
            'user_id'    => $event->user->id,
            'email'      => $event->user->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status'     => 'success',
            'login_at'   => now(),
        ]);
    }
}