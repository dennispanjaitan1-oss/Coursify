<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $query = Report::with('reporter')->latest();

        if ($request->filled('status')) {
            $query->where('status', (string) $request->string('status'));
        }

        if ($request->filled('search')) {
            $search = (string) $request->string('search');

            $query->where(function ($reportQuery) use ($search) {
                $reportQuery
                    ->where('reason', 'like', "%{$search}%")
                    ->orWhere('reported_type', 'like', "%{$search}%")
                    ->orWhereHas('reporter', function ($reporterQuery) use ($search) {
                        $reporterQuery
                            ->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        $stats = [
            'total'     => Report::count(),
            'pending'   => Report::where('status', 'pending')->count(),
            'resolved'  => Report::where('status', 'resolved')->count(),
            'dismissed' => Report::where('status', 'dismissed')->count(),
        ];

        $statusClassMap = [
            'pending'   => 'bg-yellow-100 text-yellow-700',
            'resolved'  => 'bg-green-100 text-green-700',
            'dismissed' => 'bg-red-100 text-red-700',
        ];

        $statusLabelMap = [
            'pending'   => 'Pending',
            'resolved'  => 'Resolved',
            'dismissed' => 'Rejected',
        ];

        $reports = $query->paginate(10)->withQueryString();

        return view('admin.reports', compact('stats', 'reports', 'statusClassMap', 'statusLabelMap'));
    }

    public function update(Request $request, Report $report): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:pending,resolved,dismissed'],
        ]);

        $report->update($validated);

        return redirect()->route('admin.reports')->with('success', 'Status laporan berhasil diperbarui.');
    }
}