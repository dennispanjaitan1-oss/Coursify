
<?php
    $adminUser = auth()->user();
?>

<header class="sticky top-0 z-30 -mx-8 px-8 py-5 mb-8" style="background:var(--admin-bg);">
    <div class="flex items-center justify-between gap-6 glass px-4">

        
        <div class="min-w-0">
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <span class="font-semibold text-gray-700">Dashboard</span>

                <?php if(isset($breadcrumb)): ?>
                    <?php if($breadcrumb): ?>
                        <i class="fa-solid fa-chevron-right text-[10px]"></i>
                        <span><?php echo e($breadcrumb); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="flex-1 max-w-xl">
            <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-[var(--text-muted)] text-sm"></i>

                <input
                    type="text"
                    placeholder="Search admin..."
                    class="w-full bg-[var(--panel)] border border-[var(--glass-border)] rounded-2xl pl-11 pr-4 py-3 text-sm text-[var(--text-strong)] shadow-sm focus:outline-none focus:ring-2 focus:ring-orange-50 focus:border-orange-200"
                >
            </div>
        </div>

        
        <div class="flex items-center gap-3">

            
                <button type="button"
                    class="relative w-11 h-11 rounded-2xl bg-[var(--panel)] border border-[var(--glass-border)] text-[var(--text-muted)] hover:text-[var(--accent)] shadow-sm transition flex items-center justify-center">
                <i class="fa-solid fa-bell"></i>

                
                <?php if(isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center">
                        <?php echo e($pendingCount > 9 ? '9+' : $pendingCount); ?>

                    </span>
                <?php endif; ?>
            </button>

            
            <div class="w-11 h-11 rounded-full bg-gradient-to-br from-[var(--accent)] to-[var(--accent-2)] text-white flex items-center justify-center font-bold shadow-sm">
                <?php echo e(strtoupper(substr($adminUser?->name ?? 'A', 0, 1))); ?>

            </div>

        </div>

    </div>
</header>
<?php /**PATH C:\laragon\www\coursify\resources\views/admin/partials/header.blade.php ENDPATH**/ ?>