<?php

namespace App\Http\View\Composers;

use App\Models\Course;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class AdminSidebarComposer
{
    public function compose(View $view): void
    {
        $pendingApprovals = Cache::remember('admin_pending_approvals', 60, function () {
            return Course::pendingApproval()->count();
        });

        $view->with('pendingApprovals', $pendingApprovals);
    }
}
