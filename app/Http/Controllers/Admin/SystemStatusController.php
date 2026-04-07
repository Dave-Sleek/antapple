<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class SystemStatusController extends Controller
{
    public function index()
    {
        // CPU Load (Linux only)
        $cpuLoad = function_exists('sys_getloadavg') ? sys_getloadavg()[0] : null;

        // Memory
        $memoryUsage = memory_get_usage(true);
        $memoryPeak = memory_get_peak_usage(true);

        // Active Users (last 5 minutes)
        $activeUsers = DB::table('sessions')
            ->where('last_activity', '>=', now()->subMinutes(5)->timestamp)
            ->count();

        // Requests per minute
        $requestsPerMinute = DB::table('user_logs')
            ->where('created_at', '>=', now()->subMinute())
            ->count();

        return view('admin.system-status', [
            'cpuLoad' => $cpuLoad,
            'memoryUsage' => $memoryUsage,
            'memoryPeak' => $memoryPeak,
            'activeUsers' => $activeUsers,
            'rpm' => $requestsPerMinute,
        ]);
    }
}
