<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserLog;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;


class UserLogController extends Controller
{
    public function index(Request $request)
    {
        $query = UserLog::query();

        // Filter by User ID
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // Filter by IP
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        // Filter by HTTP Method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        // Filter by Endpoint
        if ($request->filled('endpoint')) {
            $query->where('endpoint', 'like', '%' . $request->endpoint . '%');
        }

        // Filter From Date
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->from);
        }

        // Filter To Date
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->to);
        }

        $logs = $query->latest()->paginate(50)->withQueryString();

        if ($request->ajax()) {
            return view('admin.user_logs.partials.logs_table', compact('logs'));
        }

        return view('admin.user_logs.index', compact('logs'));
    }


    public function export()
    {
        $fileName = 'user_logs.csv';

        $logs = UserLog::latest()->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate",
        ];

        $columns = [
            'ID',
            'User ID',
            'IP Address',
            'Method',
            'Endpoint',
            'User Agent',
            'Location',
            'Created At'
        ];

        $callback = function () use ($logs, $columns) {

            $file = fopen('php://output', 'w');

            fputcsv($file, $columns);

            foreach ($logs as $log) {

                fputcsv($file, [
                    $log->id,
                    $log->user_id,
                    $log->ip_address,
                    $log->method,
                    $log->endpoint,
                    $log->user_agent,
                    $log->location,
                    $log->created_at
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
