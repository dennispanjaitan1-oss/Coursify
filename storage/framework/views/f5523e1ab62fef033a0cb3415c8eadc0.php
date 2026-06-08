

<?php $__env->startSection('title', 'Browse Courses — Coursify'); ?>

<?php $__env->startPush('styles'); ?>
<style>
/* ═══════════════════════════════════════════
   COURSES INDEX — page-specific styles only
   (global vars, body bg, navbar sudah dari layouts/app.blade.php)
═══════════════════════════════════════════ */

/* ═══ PAGE HERO ═══ */
.page-hero {
    text-align: center;
    padding: 48px 20px 40px;
    position: relative;
    z-index: 1;
}
.page-hero-title {
    font-family: var(--font-serif);
    font-size: clamp(38px, 6vw, 68px);
    font-weight: 400;
    line-height: 1.1;
    letter-spacing: -0.02em;
    margin-bottom: 14px;
    overflow: visible;
}
.page-hero-title em {
    font-style: italic;
    background: linear-gradient(135deg, #9F94F2, #7B6FE8);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    display: inline-block;
    padding-bottom: 0.25em;
    line-height: 1.3;
    padding-right: 0.15em;
}
.page-hero-subtitle {
    font-size: 15px;
    line-height: 1.6;
    color: var(--text-soft);
    max-width: 560px;
    margin: 0 auto 32px;
}

/* ═══ SEARCH BAR ═══ */
.search-wrap { max-width: 640px; margin: 0 auto; position: relative; }
.search-input {
    width: 100%;
    padding: 16px 60px 16px 52px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(20px);
    border: 1.5px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-family: var(--font-sans);
    font-size: 15px;
    color: var(--text);
    outline: none;
    transition: all 0.2s;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
}
.search-input::placeholder { color: var(--muted); }
.search-input:focus {
    background: white;
    border-color: var(--purple);
    box-shadow: 0 0 0 6px rgba(123,111,232,0.12), 0 10px 40px rgba(30,58,95,0.08);
}
.search-icon-left {
    position: absolute; left: 22px; top: 50%;
    transform: translateY(-50%);
    font-size: 18px; color: var(--muted); pointer-events: none;
}
.search-btn {
    position: absolute; right: 8px; top: 50%;
    transform: translateY(-50%);
    padding: 9px 20px;
    background: #1A1825; color: white;
    border: none; border-radius: 100px;
    font-family: var(--font-sans); font-size: 13px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}
.search-btn:hover { background: #2A2840; }

/* ═══ POPULAR SEARCHES ═══ */
.popular-searches {
    display: flex; gap: 8px; justify-content: center;
    flex-wrap: wrap; margin-top: 20px;
    max-width: 640px; margin-left: auto; margin-right: auto;
}
.popular-label { font-size: 12px; color: var(--muted); font-weight: 500; letter-spacing: 0.02em; padding-top: 5px; }
.popular-tag {
    padding: 6px 14px;
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 100px;
    font-size: 12px; color: var(--text-soft); font-weight: 500;
    text-decoration: none; cursor: pointer; transition: all 0.2s;
}
.popular-tag:hover { background: white; color: var(--purple); transform: translateY(-1px); }

/* ═══ STATS BAR ═══ */
.stats-bar {
    max-width: 880px; margin: 32px auto 0;
    background: rgba(255,255,255,0.5);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8);
    border-radius: 20px; padding: 20px 32px;
    display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;
}
.stat-item { text-align: center; border-right: 1px solid rgba(30,58,95,0.08); }
.stat-item:last-child { border-right: none; }
.stat-value {
    font-family: var(--font-serif); font-size: 26px;
    font-weight: 400; letter-spacing: -0.02em; line-height: 1; margin-bottom: 4px;
}
.stat-value em { font-style: italic; color: var(--purple); }
.stat-label { font-size: 10px; color: var(--muted); font-weight: 600; letter-spacing: 0.05em; text-transform: uppercase; }

/* ═══ MAIN LAYOUT ═══ */
.main-section { padding: 40px 20px 60px; }
.layout-grid { display: grid; grid-template-columns: 260px 1fr; gap: 24px; align-items: start; }

/* ═══ FILTER SIDEBAR ═══ */
.filter-sidebar {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(30px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px; padding: 24px;
    position: sticky; top: 110px;
    max-height: calc(100vh - 140px);
    overflow-y: auto;
    box-shadow: 0 10px 30px rgba(30,58,95,0.05);
}
.filter-sidebar::-webkit-scrollbar { width: 4px; }
.filter-sidebar::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }
.filter-header {
    display: flex; align-items: center;
    justify-content: space-between;
    margin-bottom: 20px; padding-bottom: 16px;
    border-bottom: 1px solid var(--border);
}
.filter-title { font-family: var(--font-serif); font-size: 20px; font-weight: 400; letter-spacing: -0.01em; }
.filter-clear {
    font-size: 11px; color: var(--purple);
    background: none; border: none; cursor: pointer;
    font-weight: 600; padding: 4px 10px; border-radius: 100px;
    transition: all 0.2s; text-decoration: none;
}
.filter-clear:hover { background: rgba(123,111,232,0.1); }
.filter-group { margin-bottom: 22px; padding-bottom: 22px; border-bottom: 1px solid var(--border); }
.filter-group:last-child { border-bottom: none; padding-bottom: 0; margin-bottom: 0; }
.filter-group-title {
    font-size: 11px; font-weight: 700; color: var(--text-soft);
    letter-spacing: 0.1em; text-transform: uppercase;
    margin-bottom: 12px;
    display: flex; align-items: center; justify-content: space-between;
}
.filter-group-count {
    background: var(--lav-1); color: var(--purple);
    padding: 2px 7px; border-radius: 100px;
    font-size: 10px; font-weight: 600; letter-spacing: 0;
}
.filter-option {
    display: flex; align-items: center; justify-content: space-between;
    padding: 7px 10px; border-radius: 8px; cursor: pointer;
    transition: background 0.2s; margin-bottom: 2px;
}
.filter-option:hover { background: var(--lav-1); }
.filter-option-left { display: flex; align-items: center; gap: 9px; flex: 1; min-width: 0; }
.filter-checkbox {
    appearance: none; width: 16px; height: 16px;
    border: 1.5px solid var(--border); border-radius: 4px;
    background: white; cursor: pointer; position: relative;
    flex-shrink: 0; transition: all 0.2s;
}
.filter-checkbox:checked { background: var(--purple); border-color: var(--purple); }
.filter-checkbox:checked::after {
    content: '✓'; position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%); color: white; font-size: 10px; font-weight: 700;
}
.filter-option-label { font-size: 13px; color: var(--text-soft); font-weight: 500; display: flex; align-items: center; gap: 6px; }
.filter-option-label i { width: 14px; text-align: center; font-size: 12px; }
.filter-option-count { font-size: 11px; color: var(--muted); font-weight: 500; }
.price-range { padding: 8px 0; }
.price-slider {
    -webkit-appearance: none; width: 100%; height: 4px;
    background: var(--lav-2); border-radius: 100px; outline: none; margin-bottom: 10px;
}
.price-slider::-webkit-slider-thumb {
    -webkit-appearance: none; width: 16px; height: 16px;
    background: var(--purple); border-radius: 50%; cursor: pointer;
    box-shadow: 0 2px 6px rgba(123,111,232,0.4);
}
.price-range-labels { display: flex; justify-content: space-between; font-size: 11px; color: var(--muted); font-weight: 500; }
.rating-option {
    display: flex; align-items: center; gap: 9px;
    padding: 7px 10px; border-radius: 8px; cursor: pointer;
    transition: background 0.2s; margin-bottom: 2px;
}
.rating-option:hover { background: var(--lav-1); }
.rating-stars { color: var(--gold); font-size: 14px; letter-spacing: 1px; }
.rating-stars-muted { color: var(--lav-3); }

/* ═══ RESULTS AREA ═══ */
.results-area { min-width: 0; }
.results-toolbar {
    display: flex; justify-content: space-between; align-items: center;
    margin-bottom: 20px; flex-wrap: wrap; gap: 12px;
    padding: 14px 20px;
    background: rgba(255,255,255,0.6); backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.8); border-radius: 14px;
}
.results-count { font-size: 13px; color: var(--text-soft); font-weight: 500; }
.results-count strong { font-family: var(--font-serif); font-size: 20px; color: var(--text); font-weight: 400; margin-right: 4px; letter-spacing: -0.01em; }
.toolbar-right { display: flex; gap: 10px; align-items: center; }
.view-toggle { display: flex; background: var(--lav-1); border-radius: 10px; padding: 3px; gap: 2px; }
.view-btn { padding: 6px 10px; border: none; background: transparent; border-radius: 8px; cursor: pointer; color: var(--muted); font-size: 14px; transition: all 0.2s; }
.view-btn.active { background: white; color: var(--purple); box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
.sort-select {
    padding: 8px 14px; background: white;
    border: 1px solid var(--border); border-radius: 10px;
    font-family: var(--font-sans); font-size: 13px; color: var(--text);
    cursor: pointer; outline: none; transition: all 0.2s; font-weight: 500;
}
.sort-select:hover { border-color: var(--purple); }
.sort-select:focus { border-color: var(--purple); box-shadow: 0 0 0 3px rgba(123,111,232,0.1); }

/* ═══ ACTIVE FILTERS ═══ */
.active-filters { display: flex; gap: 8px; flex-wrap: wrap; margin-bottom: 18px; align-items: center; }
.active-filter-label { font-size: 12px; color: var(--muted); font-weight: 500; }
.active-filter-tag {
    display: inline-flex; align-items: center; gap: 6px;
    padding: 5px 12px;
    background: rgba(123,111,232,0.1); color: var(--purple-dark);
    border: 1px solid rgba(123,111,232,0.2); border-radius: 100px;
    font-size: 12px; font-weight: 600; transition: all 0.2s; cursor: pointer;
}
.active-filter-tag:hover { background: rgba(123,111,232,0.15); }
.active-filter-remove { background: none; border: none; cursor: pointer; color: var(--purple); font-size: 13px; padding: 0; line-height: 1; font-weight: 700; }

/* ═══ COURSE GRID ═══ */
.courses-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 18px; }
.course-card {
    background: var(--color-card, #fff);
    border-radius: 12px;
    border: 1px solid var(--border, rgba(0,0,0,0.08));
    overflow: hidden;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: pointer;
}

.course-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(0,0,0,0.12);
}

.course-card__thumb img {
    transition: transform 0.3s ease;
}

.course-card:hover .course-card__thumb img {
    transform: scale(1.04);
}

/* ═══ PAGINATION ═══ */
.pagination { display: flex; justify-content: center; gap: 6px; margin-top: 40px; align-items: center; flex-wrap: wrap; }
.page-btn {
    min-width: 38px; height: 38px; border-radius: 10px;
    border: 1px solid var(--border);
    background: rgba(255,255,255,0.7); backdrop-filter: blur(10px);
    font-family: var(--font-sans); font-size: 13px; font-weight: 600;
    color: var(--text-soft); cursor: pointer; transition: all 0.2s;
    display: inline-flex; align-items: center; justify-content: center;
    padding: 0 10px; text-decoration: none;
}
.page-btn:hover:not([disabled]) { background: white; border-color: var(--purple); color: var(--purple); }
.page-btn.active { background: #1A1825; border-color: #1A1825; color: white; cursor: default; }
.page-btn[disabled] { opacity: 0.4; cursor: not-allowed; pointer-events: none; }
.page-dots { color: var(--muted); padding: 0 4px; font-weight: 600; }

/* ═══ EMPTY STATE ═══ */
.empty-state {
    text-align: center; padding: 60px 20px;
    background: rgba(255,255,255,0.5); backdrop-filter: blur(20px);
    border-radius: 20px; border: 1px solid rgba(255,255,255,0.8);
}
.empty-icon { font-size: 56px; margin-bottom: 16px; color: var(--purple); opacity: 0.6; }
.empty-title { font-family: var(--font-serif); font-size: 24px; font-weight: 400; margin-bottom: 8px; letter-spacing: -0.01em; }
.empty-desc { font-size: 13px; color: var(--muted); max-width: 380px; margin: 0 auto 20px; line-height: 1.6; }

/* ═══ CATEGORY ACCORDION ═══ */
.cat-accordion {
    border-radius: 10px;
    margin-bottom: 2px;
    transition: background 0.15s;
}
.cat-accordion.open {
    background: rgba(123,111,232,0.04);
    border: 1px solid rgba(123,111,232,0.08);
}
.cat-parent-row {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 7px 10px; border-radius: 8px;
    cursor: pointer; transition: background 0.15s;
    gap: 6px;
}
.cat-parent-row:hover { background: var(--lav-1); }
.cat-parent-left { flex: 1; min-width: 0; }
.cat-parent-right {
    display: flex; align-items: center; gap: 6px;
    flex-shrink: 0;
}
.cat-chevron {
    font-size: 14px; color: var(--muted);
    transition: transform 0.2s; display: inline-block;
    line-height: 1; user-select: none;
    width: 14px; text-align: center;
}
.cat-accordion.open .cat-chevron { transform: none; }
.cat-children {
    padding: 4px 0 6px 26px;
    border-left: 2px solid var(--lav-2);
    margin-left: 22px;
    margin-bottom: 4px;
}
.cat-child-row {
    padding: 5px 8px !important;
    border-radius: 6px !important;
    margin-bottom: 1px !important;
}
.cat-child-row .filter-option-label {
    font-size: 12px !important;
}

/* ═══ RESPONSIVE ═══ */
@media (max-width: 1100px) {
    .layout-grid { grid-template-columns: 240px 1fr; }
    .courses-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 900px) {
    .layout-grid { grid-template-columns: 1fr; }
    .filter-sidebar { position: static; max-height: none; }
    .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 16px 20px; }
    .stat-item:nth-child(2) { border-right: none; }
}
@media (max-width: 640px) {
    .courses-grid { grid-template-columns: 1fr; }
    .results-toolbar { flex-direction: column; align-items: flex-start; }
    .search-input { padding: 14px 50px 14px 46px; font-size: 14px; }
    .search-btn { display: none; }
}
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>




<section class="page-hero">
    <div class="container">
        <h1 class="page-hero-title">Find your perfect <em>course</em></h1>
        <p class="page-hero-subtitle">
            Browse our curated collection of courses from world-class instructors. Filter, compare, and start learning today.
        </p>

        
        <form action="<?php echo e(route('courses.index')); ?>" method="GET" class="search-wrap">
            
            <?php $__currentLoopData = request()->except('search', 'page'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(is_array($value)): ?>
                    <?php $__currentLoopData = $value; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <input type="hidden" name="<?php echo e($key); ?>[]" value="<?php echo e($v); ?>">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <input type="hidden" name="<?php echo e($key); ?>" value="<?php echo e($value); ?>">
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <span class="search-icon-left">🔍</span>
            <input type="text" name="search" class="search-input"
                placeholder="Search for courses, instructors, or topics..."
                value="<?php echo e(request('search')); ?>" autocomplete="off">
            <button type="submit" class="search-btn">Search</button>
        </form>

        
        <div class="popular-searches">
            <span class="popular-label">Popular:</span>
            <a href="<?php echo e(route('courses.index', ['search' => 'laravel'])); ?>" class="popular-tag">Laravel</a>
            <a href="<?php echo e(route('courses.index', ['search' => 'react'])); ?>" class="popular-tag">React.js</a>
            <a href="<?php echo e(route('courses.index', ['search' => 'python'])); ?>" class="popular-tag">Python</a>
            <a href="<?php echo e(route('courses.index', ['search' => 'design'])); ?>" class="popular-tag">UI/UX Design</a>
            <a href="<?php echo e(route('courses.index', ['search' => 'data'])); ?>" class="popular-tag">Data Science</a>
        </div>

        
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value"><em><?php echo e($totalCourses); ?>+</em></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em><?php echo e($categories->count()); ?>+</em></div>
                <div class="stat-label">Categories</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>50K+</em></div>
                <div class="stat-label">Students</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>98%</em></div>
                <div class="stat-label">Satisfaction</div>
            </div>
        </div>
    </div>
</section>




<section class="main-section">
    <div class="container">
        <div class="layout-grid">

            
            
            
            <form id="filterForm" method="GET" action="<?php echo e(route('courses.index')); ?>">
                <?php if(request()->filled('search')): ?>
                    <input type="hidden" name="search" value="<?php echo e(request('search')); ?>">
                <?php endif; ?>

                <aside class="filter-sidebar">
                    <div class="filter-header">
                        <h3 class="filter-title">Filters</h3>
                        <a href="<?php echo e(route('courses.index')); ?>" class="filter-clear">Clear all</a>
                    </div>

                    
                    <?php
                        $iconMap = [
                            'Technology' => 'fa-laptop', 'Programming' => 'fa-code', 'Design' => 'fa-pen-nib',
                            'Business' => 'fa-briefcase', 'Marketing' => 'fa-bullhorn', 'Data Science' => 'fa-chart-line',
                            'Video' => 'fa-film', 'Languages' => 'fa-language', 'Language' => 'fa-language',
                            'Music' => 'fa-music', 'Finance' => 'fa-coins', 'Health' => 'fa-heart-pulse',
                            'Photography' => 'fa-camera', 'DevOps' => 'fa-server', 'Architecture' => 'fa-building-columns',
                            'Art' => 'fa-palette', 'Science' => 'fa-flask', 'Engineering' => 'fa-gears',
                            'Mathematics' => 'fa-square-root-variable', 'Social Science' => 'fa-people-group', 'Economics' => 'fa-chart-bar',
                            'Psychology' => 'fa-brain', 'Education' => 'fa-graduation-cap', 'Law' => 'fa-scale-balanced',
                            'Medicine' => 'fa-stethoscope', 'Environmental' => 'fa-leaf', 'History' => 'fa-landmark',
                            'Philosophy' => 'fa-book-open', 'Literature' => 'fa-book', 'Cybersecurity' => 'fa-shield',
                        ];
                        $activeCats = (array) request('category', []);
                        
                        // Filter kategori yang punya courses (parent atau children)
                        $filteredParents = $parentCategories->filter(function($parent) {
                            $totalCount = $parent->courses_count + $parent->children->sum('courses_count');
                            return $totalCount > 0;
                        });
                    ?>

                    <div class="filter-group" style="padding-bottom:0;border-bottom:none;">
                        <div class="filter-group-title" style="margin-bottom:10px;">
                            <span>Category</span>
                            <span class="filter-group-count"><?php echo e($filteredParents->count()); ?></span>
                        </div>

                        <?php $__empty_1 = true; $__currentLoopData = $filteredParents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <?php
                                $parentIcon = $iconMap[$parent->name] ?? 'fa-book-open';
                                // Filter children yang punya courses
                                $childrenWithCourses = $parent->children->filter(fn($c) => $c->courses_count > 0);
                                $hasChildren = $childrenWithCourses->count() > 0;
                                $isParentChecked = in_array($parent->slug, $activeCats);
                                $anyChildActive = $childrenWithCourses->contains(fn($c) => in_array($c->slug, $activeCats));
                                $isOpen = $isParentChecked || $anyChildActive;
                                $totalCount = $parent->courses_count + $childrenWithCourses->sum('courses_count');
                            ?>

                            <div class="cat-accordion <?php echo e($isOpen ? 'open' : ''); ?>" data-id="cat-<?php echo e($parent->id); ?>">

                                
                                <div class="cat-parent-row" onclick="toggleCat('cat-<?php echo e($parent->id); ?>')">
                                    <div class="cat-parent-left">
                                        <label class="filter-option" style="padding:0;margin:0;flex:1;" onclick="event.stopPropagation()">
                                            <div class="filter-option-left">
                                                <input type="checkbox"
                                                    class="filter-checkbox"
                                                    name="category[]"
                                                    value="<?php echo e($parent->slug); ?>"
                                                    <?php if($isParentChecked): echo 'checked'; endif; ?>
                                                    onchange="document.getElementById('filterForm').submit()">
                                                <span class="filter-option-label">
                                                    <i class="fa-solid <?php echo e($parentIcon); ?>" style="width:16px;text-align:center;color:<?php echo e($isParentChecked || $anyChildActive ? 'var(--purple)' : 'var(--muted)'); ?>;"></i>
                                                    <span style="font-weight:<?php echo e($isParentChecked || $anyChildActive ? '700' : '500'); ?>;color:<?php echo e($isParentChecked || $anyChildActive ? 'var(--purple)' : 'var(--text-soft)'); ?>"><?php echo e($parent->name); ?></span>
                                                </span>
                                            </div>
                                        </label>
                                    </div>
                                    <div class="cat-parent-right">
                                        <?php if($totalCount > 0): ?>
                                            <span class="filter-option-count"><?php echo e($totalCount); ?></span>
                                        <?php endif; ?>
                                        <?php if($hasChildren): ?>
                                            <span class="cat-chevron"><?php echo e($isOpen ? '▾' : '›'); ?></span>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                
                                <?php if($hasChildren): ?>
                                    <div class="cat-children" style="<?php echo e($isOpen ? '' : 'display:none;'); ?>">
                                        <?php $__currentLoopData = $childrenWithCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $isChildChecked = in_array($child->slug, $activeCats);
                                            ?>
                                            <label class="filter-option cat-child-row">
                                                <div class="filter-option-left">
                                                    <input type="checkbox"
                                                        class="filter-checkbox"
                                                        name="category[]"
                                                        value="<?php echo e($child->slug); ?>"
                                                        <?php if($isChildChecked): echo 'checked'; endif; ?>
                                                        onchange="document.getElementById('filterForm').submit()">
                                                    <span class="filter-option-label" style="color:<?php echo e($isChildChecked ? 'var(--purple)' : ''); ?>">
                                                        <?php echo e($child->name); ?>

                                                    </span>
                                                </div>
                                                <?php if($child->courses_count > 0): ?>
                                                    <span class="filter-option-count"><?php echo e($child->courses_count); ?></span>
                                                <?php endif; ?>
                                            </label>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p style="font-size:12px;color:var(--muted);padding:8px 10px;">No categories found</p>
                        <?php endif; ?>
                    </div>

                    
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Level</span></div>
                        <?php $__currentLoopData = [
                            ['label' => 'Beginner',     'value' => 'beginner'],
                            ['label' => 'Intermediate',  'value' => 'intermediate'],
                            ['label' => 'Advanced',      'value' => 'advanced'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $level): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="filter-option">
                                <div class="filter-option-left">
                                    <input type="checkbox"
                                        class="filter-checkbox"
                                        name="difficulty[]"
                                        value="<?php echo e($level['value']); ?>"
                                        <?php if(in_array($level['value'], (array) request('difficulty', []))): echo 'checked'; endif; ?>
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="filter-option-label"><?php echo e($level['label']); ?></span>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Price</span></div>
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" name="price[]" value="free"
                                    <?php if(in_array('free', (array) request('price', []))): echo 'checked'; endif; ?>
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="filter-option-label"><i class="fa-solid fa-gift" style="color:var(--teal);"></i> Free courses</span>
                            </div>
                        </label>
                        <label class="filter-option">
                            <div class="filter-option-left">
                                <input type="checkbox" class="filter-checkbox" name="price[]" value="paid"
                                    <?php if(in_array('paid', (array) request('price', []))): echo 'checked'; endif; ?>
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="filter-option-label"><i class="fa-solid fa-crown" style="color:var(--orange);"></i> Premium</span>
                            </div>
                        </label>
                        <div class="price-range" style="margin-top:10px;">
                            <input type="range" min="0" max="500000" step="50000"
                                name="max_price" id="priceSlider"
                                value="<?php echo e(request('max_price', 500000)); ?>"
                                class="price-slider"
                                oninput="updatePriceDisplay(this.value)"
                                onchange="document.getElementById('filterForm').submit()">
                            <div class="price-range-labels">
                                <span>Rp 0</span>
                                <span id="priceDisplay">
                                    <?php echo e(request('max_price', 500000) >= 500000
                                        ? 'Rp 500K+'
                                        : 'Rp '.number_format(request('max_price'), 0, ',', '.')); ?>

                                </span>
                                <span>Rp 500K+</span>
                            </div>
                        </div>
                    </div>

                    
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Rating</span></div>
                        <?php $__currentLoopData = [5, 4, 3]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stars): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="rating-option">
                                <input type="radio" class="filter-checkbox" name="rating" value="<?php echo e($stars); ?>"
                                    <?php if((string)request('rating') === (string)$stars): echo 'checked'; endif; ?>
                                    onchange="document.getElementById('filterForm').submit()">
                                <span class="rating-stars">
                                    <?php echo e(str_repeat('★', $stars)); ?><span class="rating-stars-muted"><?php echo e(str_repeat('★', 5 - $stars)); ?></span>
                                </span>
                                <span class="filter-option-label" style="font-size:12px;">& up</span>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <div class="filter-group">
                        <div class="filter-group-title"><span>Language</span></div>
                        <?php $__currentLoopData = [
                            ['value' => 'id', 'label' => 'Indonesia', 'icon' => 'fa-earth-asia'],
                            ['value' => 'en', 'label' => 'English', 'icon' => 'fa-earth-americas'],
                        ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <label class="filter-option">
                                <div class="filter-option-left">
                                    <input type="checkbox" class="filter-checkbox"
                                        name="language[]" value="<?php echo e($lang['value']); ?>"
                                        <?php if(in_array($lang['value'], (array) request('language', []))): echo 'checked'; endif; ?>
                                        onchange="document.getElementById('filterForm').submit()">
                                    <span class="filter-option-label"><i class="fa-solid <?php echo e($lang['icon']); ?>"></i> <?php echo e($lang['label']); ?></span>
                                </div>
                            </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    
                    <noscript>
                        <button type="submit" style="width:100%;margin-top:12px;padding:10px;background:#1A1825;color:white;border:none;border-radius:100px;cursor:pointer;font-weight:600;">
                            Apply Filters
                        </button>
                    </noscript>
                </aside>
            </form>

            
            
            
            <div class="results-area">

                
                <div class="results-toolbar">
                    <div class="results-count">
                        <strong><?php echo e($courses->total()); ?></strong>
                        course<?php echo e($courses->total() !== 1 ? 's' : ''); ?> found
                        <?php if(request('search')): ?>
                            for "<span style="color:var(--purple);font-weight:600;"><?php echo e(request('search')); ?></span>"
                        <?php endif; ?>
                    </div>
                    <div class="toolbar-right">
                        <div class="view-toggle">
                            <button class="view-btn active" title="Grid view" onclick="switchView('grid', this)" type="button">▦</button>
                            <button class="view-btn" title="List view" onclick="switchView('list', this)" type="button">☰</button>
                        </div>
                        <select class="sort-select" name="sort" form="filterForm"
                            onchange="document.getElementById('filterForm').submit()">
                            <option value="popular"    <?php if(request('sort', 'popular') === 'popular'): echo 'selected'; endif; ?>>Most Popular</option>
                            <option value="newest"     <?php if(request('sort') === 'newest'): echo 'selected'; endif; ?>>Newest First</option>
                            <option value="rating"     <?php if(request('sort') === 'rating'): echo 'selected'; endif; ?>>Highest Rated</option>
                            <option value="price_low"  <?php if(request('sort') === 'price_low'): echo 'selected'; endif; ?>>Price: Low to High</option>
                            <option value="price_high" <?php if(request('sort') === 'price_high'): echo 'selected'; endif; ?>>Price: High to Low</option>
                        </select>
                    </div>
                </div>

                
                <?php
                    $activeFilters = [];
                    foreach ((array) request('category', []) as $slug) {
                        $cat = $categories->firstWhere('slug', $slug);
                        if ($cat) $activeFilters[] = ['label' => $cat->name, 'param' => 'category', 'value' => $slug];
                    }
                    foreach ((array) request('difficulty', []) as $diff) {
                        $activeFilters[] = ['label' => ucfirst($diff), 'param' => 'difficulty', 'value' => $diff];
                    }
                    foreach ((array) request('price', []) as $p) {
                        $label = $p === 'free' ? 'Free' : 'Premium';
                        $activeFilters[] = ['label' => $label, 'param' => 'price', 'value' => $p];
                    }
                    if (request()->filled('rating')) {
                        $activeFilters[] = ['label' => request('rating').'+ stars', 'param' => 'rating', 'value' => request('rating')];
                    }
                    foreach ((array) request('language', []) as $lang) {
                        $label = $lang === 'id' ? 'Indonesia' : 'English';
                        $activeFilters[] = ['label' => $label, 'param' => 'language', 'value' => $lang];
                    }
                    if (request()->filled('search')) {
                        $activeFilters[] = ['label' => '"'.request('search').'"', 'param' => 'search', 'value' => request('search')];
                    }
                ?>

                <?php if(count($activeFilters) > 0): ?>
                    <div class="active-filters">
                        <span class="active-filter-label">Active:</span>
                        <?php $__currentLoopData = $activeFilters; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $filter): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <span class="active-filter-tag"
                                onclick="removeFilter('<?php echo e($filter['param']); ?>', '<?php echo e($filter['value']); ?>')"
                                title="Remove filter">
                                <?php echo e($filter['label']); ?>

                                <button class="active-filter-remove" type="button">✕</button>
                            </span>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>

                
                <div class="courses-grid" id="coursesGrid">
                    <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <?php echo $__env->make('components.course-card', ['course' => $course], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="empty-state" style="grid-column: 1 / -1;">
                            <div class="empty-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
                            <div class="empty-title">No courses found</div>
                            <p class="empty-desc">
                                <?php if(request()->hasAny(['search', 'category', 'difficulty', 'price', 'rating', 'language'])): ?>
                                    Try adjusting your filters or search terms.
                                <?php else: ?>
                                    No published courses yet. Check back soon!
                                <?php endif; ?>
                            </p>
                            <a href="<?php echo e(route('courses.index')); ?>"
                                style="display:inline-block;padding:10px 24px;background:#1A1825;color:white;border-radius:100px;text-decoration:none;font-weight:600;font-size:13px;">
                                Clear filters &amp; browse all
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($courses->hasPages()): ?>
                    <div class="pagination">
                        <?php if($courses->onFirstPage()): ?>
                            <button class="page-btn" disabled>← Prev</button>
                        <?php else: ?>
                            <a href="<?php echo e($courses->previousPageUrl()); ?>" class="page-btn">← Prev</a>
                        <?php endif; ?>

                        <?php
                            $current = $courses->currentPage();
                            $last    = $courses->lastPage();
                            $start   = max(1, $current - 2);
                            $end     = min($last, $current + 2);
                        ?>

                        <?php if($start > 1): ?>
                            <a href="<?php echo e($courses->url(1)); ?>" class="page-btn">1</a>
                            <?php if($start > 2): ?><span class="page-dots">…</span><?php endif; ?>
                        <?php endif; ?>

                        <?php for($p = $start; $p <= $end; $p++): ?>
                            <?php if($p === $current): ?>
                                <button class="page-btn active"><?php echo e($p); ?></button>
                            <?php else: ?>
                                <a href="<?php echo e($courses->url($p)); ?>" class="page-btn"><?php echo e($p); ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if($end < $last): ?>
                            <?php if($end < $last - 1): ?><span class="page-dots">…</span><?php endif; ?>
                            <a href="<?php echo e($courses->url($last)); ?>" class="page-btn"><?php echo e($last); ?></a>
                        <?php endif; ?>

                        <?php if($courses->hasMorePages()): ?>
                            <a href="<?php echo e($courses->nextPageUrl()); ?>" class="page-btn">Next →</a>
                        <?php else: ?>
                            <button class="page-btn" disabled>Next →</button>
                        <?php endif; ?>
                    </div>

                    <p style="text-align:center;margin-top:12px;font-size:12px;color:var(--muted);font-weight:500;">
                        Showing <?php echo e($courses->firstItem()); ?>–<?php echo e($courses->lastItem()); ?> of <?php echo e($courses->total()); ?> courses
                    </p>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// ── Category accordion toggle ──────────────────────────
function toggleCat(id) {
    const el = document.querySelector(`[data-id="${id}"]`);
    if (!el) return;
    const children = el.querySelector('.cat-children');
    const chevron  = el.querySelector('.cat-chevron');
    const isOpen   = el.classList.contains('open');
    el.classList.toggle('open', !isOpen);
    if (children) children.style.display = isOpen ? 'none' : 'block';
    if (chevron)  chevron.textContent     = isOpen ? '›' : '▾';
}

// ── Wishlist toggle (AJAX, tanpa reload) ──────────────
function toggleWishlist(btn, courseId) {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!csrfToken) {
        window.location.href = '/login';
        return;
    }
    btn.disabled = true;
    const wasActive = btn.classList.contains('active');
    fetch(`/wishlist/toggle/${courseId}`, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
    })
    .then(res => {
        if (res.status === 401) {
            return res.json().then(d => { window.location.href = d.redirect || '/login'; });
        }
        return res.json().then(data => {
            btn.disabled = false;
            const added = data.status === 'added';
            btn.classList.toggle('active', added);
            btn.innerHTML = added
                ? '<i class="fa-solid fa-heart"></i>'
                : '<i class="fa-regular fa-heart"></i>';
            btn.title = added ? 'Hapus dari wishlist' : 'Simpan ke wishlist';

            // Tampilkan mini-toast konfirmasi
            showWishlistToast(added
                ? 'Ditambahkan ke wishlist ❤️'
                : 'Dihapus dari wishlist');
        });
    })
    .catch(() => {
        btn.disabled = false;
        btn.classList.toggle('active', wasActive); // rollback
    });
}

// Mini toast untuk konfirmasi wishlist
function showWishlistToast(msg) {
    let toast = document.getElementById('wl-toast');
    if (!toast) {
        toast = document.createElement('div');
        toast.id = 'wl-toast';
        toast.style.cssText = `
            position:fixed; bottom:24px; left:50%; transform:translateX(-50%) translateY(20px);
            background:#1A1825; color:white; padding:10px 20px; border-radius:100px;
            font-size:13px; font-weight:600; z-index:9999; opacity:0;
            transition:all 0.3s cubic-bezier(0.34,1.2,0.64,1); pointer-events:none;
            font-family:'Plus Jakarta Sans',sans-serif;
        `;
        document.body.appendChild(toast);
    }
    toast.textContent = msg;
    requestAnimationFrame(() => {
        toast.style.opacity = '1';
        toast.style.transform = 'translateX(-50%) translateY(0)';
    });
    clearTimeout(toast._timer);
    toast._timer = setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(-50%) translateY(20px)';
    }, 2500);
}

// ── Price slider display ───────────────────────────────
function updatePriceDisplay(value) {
    const display = document.getElementById('priceDisplay');
    if (!display) return;
    const num = parseInt(value);
    if (num >= 500000)      display.textContent = 'Rp 500K+';
    else if (num >= 1000)   display.textContent = 'Rp ' + (num / 1000).toFixed(0) + 'K';
    else                    display.textContent = 'Rp ' + num;
}

// ── View toggle (grid / list) ──────────────────────────
function switchView(view, btn) {
    document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    const grid = document.getElementById('coursesGrid');
    if (grid) grid.style.gridTemplateColumns = view === 'list' ? '1fr' : '';
}

// ── Hapus satu active filter dari URL ─────────────────
function removeFilter(param, value) {
    const url = new URL(window.location.href);
    const sp  = url.searchParams;
    if (param === 'search' || param === 'rating') {
        sp.delete(param);
    } else {
        const key      = param + '[]';
        const existing = sp.getAll(key).filter(v => v !== value);
        sp.delete(key);
        existing.forEach(v => sp.append(key, v));
    }
    sp.delete('page');
    window.location.href = url.toString();
}
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\coursify\resources\views/courses/index.blade.php ENDPATH**/ ?>