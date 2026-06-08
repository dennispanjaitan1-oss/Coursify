<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    public function index(Request $request): View
    {
        $query = Activity::query()->latest();

        if ($request->filled('level')) {
            $query->where('log_name', strtolower((string) $request->string('level')));
        }

        if ($request->filled('search')) {
            $search = (string) $request->string('search');
            $query->where('description', 'like', "%{$search}%");
        }

        $stats = [
            'total' => Activity::count(),
            'info' => Activity::where('log_name', 'info')->count(),
            'warning' => Activity::where('log_name', 'warning')->count(),
            'error' => Activity::where('log_name', 'error')->count(),
        ];

        $logs = $query->paginate(15)->withQueryString();

        $logs->getCollection()->transform(function (Activity $activity) {
            $level = strtolower($activity->log_name ?: $activity->getProperty('level', 'info'));

            $activity->display_level = Str::upper($level);
            $activity->display_ip = $activity->getProperty('ip_address', '-');
            $activity->display_status = $activity->getProperty('status', $level === 'error' ? 'failed' : 'success');

            return $activity;
        });

        $levelClassMap = [
            'info'    => 'bg-blue-100 text-blue-700',
            'warning' => 'bg-yellow-100 text-yellow-700',
            'error'   => 'bg-red-100 text-red-700',
        ];

        $statusClassMap = [
            'success' => 'bg-green-100 text-green-700',
            'warning' => 'bg-yellow-100 text-yellow-700',
            'failed'  => 'bg-red-100 text-red-700',
        ];

        return view('admin.logs', compact('stats', 'logs', 'levelClassMap', 'statusClassMap'));
    }
}
