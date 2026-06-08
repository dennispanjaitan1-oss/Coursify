<?php
    $adminUser = auth()->user();
    $baseLink = 'flex items-center gap-3 px-4 py-3 rounded-2xl text-sm transition';
    $activeLink = 'bg-[var(--accent)] text-white shadow-sm';
    $inactiveLink = 'text-[var(--text-strong)] hover:bg-[var(--panel)] hover:text-[var(--accent)]';
    $sectionLabel = 'px-4 pt-5 pb-2 text-[11px] font-bold uppercase tracking-[0.16em] text-[var(--text-muted)]';
?>

<aside class="w-72 p-5 flex flex-col justify-between min-h-screen sticky top-0 glass">

    <div>

        
        <div class="flex items-center gap-3 mb-8 pb-5 border-b border-gray-100">

            <div class="w-12 h-12 rounded-2xl overflow-hidden shadow-sm">
                <img
                    src="<?php echo e(asset('images/logo.png')); ?>"
                    alt="Logo"
                    class="w-full h-full object-cover"
                >
            </div>

            <div>
                <h1 class="text-lg font-bold text-gray-900">
                    Ruang<span class="text-orange-500">Kelas</span>
                </h1>

                <p class="text-xs text-gray-400">
                    Admin Dashboard
                </p>
            </div>

        </div>

        
        <nav class="space-y-1">

            
            <a href="<?php echo e(route('admin.dashboard')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.dashboard') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-chart-line w-5 text-center"></i>
                <span class="font-medium">Dashboard</span>
            </a>

            
            <a href="<?php echo e(route('admin.analytics')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.analytics') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                <span class="font-medium">Analytics</span>
            </a>

            <div class="<?php echo e($sectionLabel); ?>">
                Management
            </div>

            
            <a href="<?php echo e(route('admin.users')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.users') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-users w-5 text-center"></i>
                <span class="font-medium">Users</span>
            </a>

            
            <a href="<?php echo e(route('admin.courses.index')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.courses.index') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-book-open w-5 text-center"></i>
                <span class="font-medium">Courses</span>
            </a>

            
            <a href="<?php echo e(route('admin.institutions')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.institutions') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-school w-5 text-center"></i>
                <span class="font-medium">Institutions</span>
            </a>

            
            <a href="<?php echo e(route('admin.categories')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.categories') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-layer-group w-5 text-center"></i>
                <span class="font-medium">Categories</span>
            </a>

            <div class="<?php echo e($sectionLabel); ?>">
                Moderation
            </div>

            
            <a href="<?php echo e(route('admin.approvals')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.approvals') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-circle-check w-5 text-center"></i>

                <span class="font-medium flex-1">
                    Approvals
                </span>

                <?php if($pendingApprovals > 0): ?>
                    <span class="min-w-6 h-6 px-2 rounded-full bg-red-500 text-white text-[11px] font-bold flex items-center justify-center">
                        <?php echo e($pendingApprovals > 99 ? '99+' : $pendingApprovals); ?>

                    </span>
                <?php endif; ?>
            </a>

            
            <a href="<?php echo e(route('admin.reviews')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.reviews') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-star w-5 text-center"></i>
                <span class="font-medium">Reviews</span>
            </a>

            
            <a href="<?php echo e(route('admin.reports')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.reports') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-flag w-5 text-center"></i>
                <span class="font-medium">Reports</span>
            </a>

            <div class="<?php echo e($sectionLabel); ?>">
                Finance
            </div>

            
            <a href="<?php echo e(route('admin.transactions')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.transactions') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-credit-card w-5 text-center"></i>
                <span class="font-medium">Transactions</span>
            </a>

            
            <a href="<?php echo e(route('admin.payouts')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.payouts') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-wallet w-5 text-center"></i>
                <span class="font-medium">Payouts</span>
            </a>

            <div class="<?php echo e($sectionLabel); ?>">
                System
            </div>

            
            <a href="<?php echo e(route('admin.settings')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.settings') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-gear w-5 text-center"></i>
                <span class="font-medium">Settings</span>
            </a>

            
            <a href="<?php echo e(route('admin.logs')); ?>"
               class="<?php echo e($baseLink); ?> <?php echo e(request()->routeIs('admin.logs') ? $activeLink : $inactiveLink); ?>">
                <i class="fa-solid fa-file-lines w-5 text-center"></i>
                <span class="font-medium">Logs</span>
            </a>

        </nav>

    </div>

    <div class="pt-5 mt-6 border-t border-gray-100">


        
        <div class="flex items-center gap-3 px-3 py-3 rounded-2xl bg-[var(--panel)] border border-[var(--glass-border)]">

            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-2)] text-white flex items-center justify-center font-bold">
                <?php echo e(strtoupper(substr($adminUser?->name ?? 'A', 0, 1))); ?>

            </div>

            <div class="min-w-0">
                <p class="text-sm font-semibold text-[var(--text-strong)] truncate">
                    <?php echo e($adminUser?->name ?? 'Admin'); ?>

                </p>

                <p class="text-xs text-[var(--text-muted)] truncate">
                    <?php echo e($adminUser?->email ?? 'admin@ruangkelas.test'); ?>

                </p>
            </div>

        </div>

        
        <form method="POST" action="<?php echo e(route('logout')); ?>" class="mt-3">
            <?php echo csrf_field(); ?>

            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 ui-btn">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
            </button>
        </form>

    </div>

</aside>
<?php /**PATH C:\laragon\www\coursify\resources\views/admin/partials/sidebar.blade.php ENDPATH**/ ?>