<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Instructor Dashboard'); ?> — Coursify</title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/logo.png')); ?>">

    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
          integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer">

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/css/instructor/dashboard.scss', 'resources/js/app.js']); ?>
</head>
<body>

    
    <a href="#main-content" class="skip-link">
        Skip to main content
    </a>

    
    <div class="sidebar-overlay"
         id="sidebarOverlay"
         aria-hidden="true"
         @click="sidebarOpen = false"></div>

    
    <aside class="sidebar"
           id="sidebar"
           role="complementary"
           aria-label="Sidebar navigation"
           x-data
           :class="{ 'open': $store.sidebar.open }">

        <a href="<?php echo e(route('home')); ?>" class="sidebar__logo" aria-label="Coursify - Back to home">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="" class="sidebar__logo-img" aria-hidden="true">
            <span class="sidebar__logo-text">Coursify</span>
        </a>

        
        <span class="sidebar__section-title" id="nav-teaching-label">Teaching</span>
        <nav class="sidebar__nav" aria-labelledby="nav-teaching-label">
            <a href="<?php echo e(route('instructor.dashboard')); ?>"
               class="sidebar__link <?php echo e(request()->routeIs('instructor.dashboard') ? 'sidebar__link--active' : ''); ?>"
               aria-current="page">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-chart-pie"></i>
                </span>
                <span>Dashboard</span>
            </a>
            <a href="<?php echo e(route('instructor.courses.index')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.courses*') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-book-open"></i>
                </span>
                <span>My Courses</span>
            </a>
            <a href="<?php echo e(route('instructor.students')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.students') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-users"></i>
                </span>
                <span>Students</span>
            </a>
            <a href="<?php echo e(route('instructor.messages')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.messages') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-envelope"></i>
                </span>
                <span>Messages</span>
            </a>
            <a href="<?php echo e(route('instructor.reviews')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.reviews') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-star"></i>
                </span>
                <span>Reviews</span>
            </a>
        </nav>

        
        <span class="sidebar__section-title" id="nav-analytics-label">Analytics</span>
        <nav class="sidebar__nav" aria-labelledby="nav-analytics-label">
            <a href="<?php echo e(route('instructor.earnings')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.earnings') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-wallet"></i>
                </span>
                <span>Earnings</span>
            </a>
            <a href="<?php echo e(route('instructor.performance')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.performance') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-chart-line"></i>
                </span>
                <span>Performance</span>
            </a>
            <a href="<?php echo e(route('instructor.insights')); ?>" class="sidebar__link <?php echo e(request()->routeIs('instructor.insights') ? 'sidebar__link--active' : ''); ?>">
                <span class="sidebar__link-icon" aria-hidden="true">
                    <i class="fa-solid fa-lightbulb"></i>
                </span>
                <span>Insights</span>
            </a>
        </nav>

        
        <div class="sidebar__cta" role="region" aria-label="Create new course">
            <div class="sidebar__cta-title">New <em>course</em>?</div>
            <div class="sidebar__cta-desc">Share your knowledge and earn by creating courses.</div>
            <a href="<?php echo e(route('instructor.courses.create')); ?>" class="sidebar__cta-btn">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Create
            </a>
        </div>

        
        <div class="sidebar__user" role="region" aria-label="User profile">
            <div class="sidebar__user-avatar" aria-hidden="true">
                <?php echo e(strtoupper(substr(auth()->user()->name ?? 'I', 0, 1))); ?>

            </div>
            <div class="sidebar__user-info">
                <div class="sidebar__user-name"><?php echo e(auth()->user()->name ?? 'Instructor'); ?></div>
                <div class="sidebar__user-role">Instructor</div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="sidebar__logout-btn"
                        aria-label="Logout from account"
                        title="Logout">
                    <i class="fa-solid fa-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </aside>

    
    <button class="mobile-menu-toggle"
            id="mobileMenuToggle"
            aria-label="Toggle navigation menu"
            aria-expanded="false"
            aria-controls="sidebar"
            @click="$store.sidebar.toggle()">
        <i class="fa-solid fa-bars"></i>
        <i class="fa-solid fa-times"></i>
    </button>

    
    <main class="main" id="main-content" role="main">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('sidebar', {
                open: false,
                toggle() {
                    this.open = !this.open;
                    const btn = document.getElementById('mobileMenuToggle');
                    const overlay = document.getElementById('sidebarOverlay');

                    btn.setAttribute('aria-expanded', this.open.toString());

                    if (this.open) {
                        overlay.classList.add('active');
                        overlay.setAttribute('aria-hidden', 'false');
                        // Trap focus in sidebar
                        document.getElementById('sidebar').querySelector('a').focus();
                    } else {
                        overlay.classList.remove('active');
                        overlay.setAttribute('aria-hidden', 'true');
                    }
                }
            });
        });

        // Close sidebar on overlay click
        document.getElementById('sidebarOverlay')?.addEventListener('click', () => {
            Alpine.store('sidebar').open = false;
            document.getElementById('mobileMenuToggle').setAttribute('aria-expanded', 'false');
            document.getElementById('sidebarOverlay').classList.remove('active');
        });

        // Close sidebar on Escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && Alpine.store('sidebar').open) {
                Alpine.store('sidebar').open = false;
                document.getElementById('mobileMenuToggle').setAttribute('aria-expanded', 'false');
                document.getElementById('sidebarOverlay').classList.remove('active');
                document.getElementById('mobileMenuToggle').focus();
            }
        });
    </script>
</body>
</html>
<?php /**PATH C:\laragon\www\coursify\resources\views/layouts/instructor.blade.php ENDPATH**/ ?>