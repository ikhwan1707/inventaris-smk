<?php

namespace App\Listeners;

use App\LoginLog;
use Illuminate\Auth\Events\Logout;

class LogSuccessfulLogout
{
    public function __construct()
    {
        //
    }

    public function handle(Logout $event)
    {
        if (!$event->user) {
            return;
        }

        // Cari log login terakhir yang belum logout
        $log = LoginLog::where('user_id', $event->user->id)
            ->whereNull('logout_at')
            ->latest('login_at')
            ->first();

        if ($log) {
            $log->update([
                'logout_at' => now(),
            ]);
        }
    }
}