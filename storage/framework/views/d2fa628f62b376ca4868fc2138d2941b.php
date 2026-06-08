

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"> 

<nav class="navbar-wrap" id="mainNavbar" x-data="{ userOpen: false }">
    <div class="navbar">

        
        <a href="<?php echo e(route('home')); ?>" class="logo">
            <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Coursify" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>

        
        <div class="nav-links">
    <a href="<?php echo e(route('courses.index')); ?>" 
       class="nav-link <?php echo e(request()->routeIs('courses.index') || request()->routeIs('courses.show') ? 'active' : ''); ?>">
        <i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i>Courses
    </a>
    <a href="<?php echo e(route('home')); ?>#how" 
       class="nav-link">
        <i class="fa-solid fa-circle-info" style="margin-right:5px;"></i>How It Works
    </a>
    <a href="<?php echo e(route('home')); ?>#pricing" 
       class="nav-link">
        <i class="fa-solid fa-tag" style="margin-right:5px;"></i>Pricing
    </a>
</div>

        
        <?php if(auth()->guard()->guest()): ?>
            <a href="<?php echo e(route('login')); ?>" class="btn-nav">
                <i class="fa-solid fa-arrow-right-to-bracket" style="margin-right:6px;"></i>Get Started
            </a>
        <?php else: ?>
            <div style="position:relative;">

                
                <button
                    @click="userOpen = !userOpen"
                    style="
                        display:flex;align-items:center;gap:8px;
                        background:white;border:none;
                        padding:4px 10px 4px 4px;
                        border-radius:100px;cursor:pointer;
                        box-shadow:0 2px 10px rgba(30,58,95,0.1);
                        transition:all 0.2s;
                    "
                    onmouseover="this.style.boxShadow='0 4px 16px rgba(30,58,95,0.15)'"
                    onmouseout="this.style.boxShadow='0 2px 10px rgba(30,58,95,0.1)'"
                >
                    <div style="
                        width:28px;height:28px;border-radius:50%;
                        background:#153759;color:white;
                        font-size:12px;font-weight:700;
                        display:flex;align-items:center;justify-content:center;
                        flex-shrink:0;
                        overflow:hidden;
                    ">
                        <?php if(auth()->user()->avatar_url): ?>
                            <img src="<?php echo e(asset(auth()->user()->avatar_url)); ?>" alt="Avatar" style="width: 100%; height: 100%; object-fit: cover;">
                        <?php else: ?>
                            <?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?>

                        <?php endif; ?>
                    </div>
                    <span style="font-size:13px;font-weight:600;color:#1A1825;">
                        <?php echo e(Str::limit(auth()->user()->name, 10)); ?>

                    </span>
                    <i class="fa-solid fa-chevron-down" style="font-size:10px;color:#8B87A8;margin-left:2px;"></i>
                </button>

                
                <div
                    x-show="userOpen"
                    @click.away="userOpen = false"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    style="
                        display:none;
                        position:absolute;top:calc(100% + 12px);right:0;
                        background:white;border-radius:20px;
                        box-shadow:0 20px 60px rgba(30,58,95,0.15);
                        padding:16px;min-width:240px;
                        border:1px solid rgba(30,58,95,0.08);
                        z-index:200;
                    "
                    x-cloak
                >
                    
                    <div style="padding:4px 8px 14px;border-bottom:1px solid rgba(30,58,95,0.08);margin-bottom:8px;">
                        <div style="font-size:15px;font-weight:700;color:#1A1825;margin-bottom:2px;">
                            <?php echo e(auth()->user()->name); ?>

                        </div>
                        <div style="font-size:12px;color:#8B87A8;margin-bottom:10px;">
                            <?php echo e(auth()->user()->email); ?>

                        </div>
                        <span style="
                            display:inline-flex;align-items:center;gap:6px;
                            background:rgba(123,111,232,0.12);color:#5B4FD4;
                            font-size:11px;font-weight:700;letter-spacing:0.08em;
                            text-transform:uppercase;padding:4px 12px;border-radius:100px;
                        ">
                            <i class="fa-solid fa-user-graduate" style="font-size:10px;"></i>
                            <?php echo e(ucfirst(auth()->user()->role)); ?>

                        </span>
                    </div>

                    
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a href="<?php echo e(route('admin.dashboard')); ?>" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-screwdriver-wrench" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Admin Panel</span>
                        </a>
                    <?php endif; ?>

                    
                    <?php if(auth()->user()->role === 'instructor'): ?>
                        <a href="<?php echo e(route('instructor.dashboard')); ?>" style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;" onmouseover="this.style.background='#F5F1FC'" onmouseout="this.style.background='transparent'">
                            <i class="fa-solid fa-chalkboard-user" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span>Instructor Dashboard</span>
                        </a>
                    <?php endif; ?>

                    
                    <?php
                        $menuItems = [
                            [
                                'icon'  => 'fa-gauge-high',
                                'label' => 'My Dashboard',
                                'route' => 'student.index',
                            ],
                            [
                                'icon'  => 'fa-book-open',
                                'label' => 'My Courses',
                                'route' => 'student.courses',
                            ],
                            [
                                'icon'  => 'fa-heart',
                                'label' => 'Wishlist',
                                'route' => 'student.wishlist',
                            ],
                            [
                                'icon'  => 'fa-trophy',
                                'label' => 'Certificates',
                                'route' => 'student.certificates',
                            ],
                        ];
                    ?>

                    <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a href="<?php echo e(route($item['route'])); ?>"
                            style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                            onmouseover="this.style.background='#F5F1FC'"
                            onmouseout="this.style.background='transparent'"
                        >
                            <i class="fa-solid <?php echo e($item['icon']); ?>" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                            <span><?php echo e($item['label']); ?></span>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <a href="<?php echo e(route('student.profile')); ?>"
                        style="display:flex;align-items:center;gap:12px;padding:10px 8px;border-radius:10px;text-decoration:none;color:#1A1825;font-size:14px;font-weight:500;transition:background 0.2s;"
                        onmouseover="this.style.background='#F5F1FC'"
                        onmouseout="this.style.background='transparent'"
                    >
                        <i class="fa-solid fa-user-pen" style="width:16px;text-align:center;color:#7B6FE8;font-size:13px;"></i>
                        <span>Profile Settings</span>
                    </a>

                    
                    <div style="border-top:1px solid rgba(30,58,95,0.08);margin-top:8px;padding-top:8px;">
                        <form method="POST" action="<?php echo e(route('logout')); ?>">
                            <?php echo csrf_field(); ?>
                            <button type="submit"
                                style="display:flex;align-items:center;gap:12px;width:100%;padding:10px 8px;border-radius:10px;background:none;border:none;color:#FF6B35;font-size:14px;font-weight:600;cursor:pointer;transition:background 0.2s;"
                                onmouseover="this.style.background='#FFF0E8'"
                                onmouseout="this.style.background='transparent'"
                            >
                                <i class="fa-solid fa-right-from-bracket" style="width:16px;text-align:center;font-size:13px;"></i>
                                <span>Sign Out</span>
                            </button>
                        </form>
                    </div>

                </div>
            </div>
        <?php endif; ?>
    </div>
</nav><?php /**PATH C:\laragon\www\coursify\resources\views/partials/navbar.blade.php ENDPATH**/ ?>