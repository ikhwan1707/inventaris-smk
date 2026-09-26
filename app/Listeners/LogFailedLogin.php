<?php

namespace App\Listeners;

use App\LoginLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
{
    public function __construct()
    {
        //
    }

    public function handle(Failed $event)
    {
        LoginLog::create([
            'user_id'    => null,
            'email'      => $event->credentials['email'] ?? null,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'status'     => 'failed',
            'login_at'   => now(),
        ]);
    }
}