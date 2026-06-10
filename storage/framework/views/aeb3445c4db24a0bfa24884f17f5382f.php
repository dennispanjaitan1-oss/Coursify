
<?php
    $adminUser = auth()->user();
?>

<header class="sticky top-0 z-30 -mx-8 px-8 py-4 mb-6" style="background: var(--admin-bg);">
    <div class="glass flex items-center justify-between gap-6 px-6 py-3.5 transition-all duration-300">

        
        <div class="flex-shrink-0 flex items-center gap-2">
            <div class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 bg-gray-100/80 px-3 py-1.5 rounded-xl border border-gray-200/50">
                <i class="fa-solid fa-house-chimney text-gray-400 text-[10px]"></i>
                <span class="hover:text-violet-600 transition cursor-pointer">Dashboard</span>
                <?php if(isset($breadcrumb)): ?>
                    <?php if($breadcrumb): ?>
                        <i class="fa-solid fa-chevron-right text-[8px] text-gray-300 mx-0.5"></i>
                        <span class="text-gray-700 font-bold"><?php echo e($breadcrumb); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        
        <div class="flex-grow max-w-lg mx-auto min-w-[240px]">
            <div class="relative group">
                <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-violet-500 text-sm transition-colors duration-200"></i>

                <input
                    type="text"
                    placeholder="Cari menu, pengguna, atau kursus..."
                    class="w-full bg-gray-100/55 hover:bg-gray-100/80 focus:bg-white border border-transparent focus:border-violet-200 rounded-2xl pl-11 pr-12 py-2.5 text-sm text-gray-800 shadow-inner focus:shadow-sm focus:outline-none focus:ring-4 focus:ring-violet-500/10 transition-all duration-300"
                >
                <div class="absolute right-3.5 top-1/2 -translate-y-1/2 bg-white/80 border border-gray-200 text-[10px] font-bold text-gray-400 px-1.5 py-0.5 rounded-lg shadow-sm pointer-events-none group-focus-within:hidden transition-all duration-200">
                    ⌘K
                </div>
            </div>
        </div>

        
        <div class="flex items-center gap-4 flex-shrink-0">

            
            <button type="button"
                    class="relative w-10 h-10 rounded-xl bg-gray-100/80 hover:bg-violet-50 border border-gray-200/40 text-gray-500 hover:text-violet-600 shadow-sm transition-all duration-200 flex items-center justify-center group active:scale-95">
                <i class="fa-solid fa-bell group-hover:animate-bounce"></i>

                
                <?php if(isset($pendingCount) && $pendingCount > 0): ?>
                    <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">
                        <?php echo e($pendingCount > 9 ? '9+' : $pendingCount); ?>

                    </span>
                <?php elseif(isset($pendingApprovals) && $pendingApprovals > 0): ?>
                    <span class="absolute -top-1 -right-1 min-w-5 h-5 px-1 rounded-full bg-red-500 text-white text-[10px] font-bold flex items-center justify-center border-2 border-white">
                        <?php echo e($pendingApprovals > 9 ? '9+' : $pendingApprovals); ?>

                    </span>
                <?php endif; ?>
            </button>

            
            <div class="w-px h-6 bg-gray-200"></div>

            
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-violet-500 to-indigo-600 text-white flex items-center justify-center font-bold shadow-md hover:shadow-lg transition-shadow duration-300 cursor-pointer">
                    <?php echo e(strtoupper(substr($adminUser?->name ?? 'A', 0, 1))); ?>

                </div>
                <div class="hidden xl:flex flex-col text-left leading-none">
                    <span class="text-xs font-bold text-gray-800"><?php echo e($adminUser?->name ?? 'Administrator'); ?></span>
                    <span class="text-[10px] text-gray-400 font-medium mt-0.5">Admin</span>
                </div>
            </div>

        </div>

    </div>
</header>
<?php /**PATH C:\laragon\www\coursify\resources\views/admin/partials/header.blade.php ENDPATH**/ ?>