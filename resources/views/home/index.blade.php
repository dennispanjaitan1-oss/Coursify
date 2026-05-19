@extends('layouts.app')

@section('title', 'Coursify - Learn Anything, Anytime')

@push('styles')
<style>
    /* ═══ HERO ═══ */
    .hero {
        padding: 70px 20px 40px;
        text-align: center;
        animation: fadeInUp 0.8s ease-out 0.2s both;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .hero-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(123,111,232,0.25);
        padding: 8px 18px;
        border-radius: 100px;
        font-size: 13px;
        font-weight: 500;
        color: var(--text-soft);
        margin-bottom: 20px;
        box-shadow: 0 8px 24px rgba(30,58,95,0.08);
        transition: all 0.3s ease;
    }
    .hero-badge:hover {
        background: rgba(255,255,255,0.95);
        border-color: rgba(123,111,232,0.4);
        transform: translateY(-2px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.12);
    }
    .hero-badge-dot {
        width: 6px;
        height: 6px;
        background: var(--teal);
        border-radius: 50%;
        animation: pulse 2s infinite;
    }
    @keyframes pulse {
        0%, 100% { opacity: 1; transform: scale(1); }
        50% { opacity: 0.5; transform: scale(1.3); }
    }

    .hero-title {
        font-family: var(--font-serif);
        font-size: clamp(48px, 8vw, 88px);
        font-weight: 400;
        line-height: 1.2;
        letter-spacing: -0.03em;
        margin-bottom: 18px;
        color: var(--text);
    }
    .hero-title em {
        font-style: italic;
        background: linear-gradient(135deg, #9F94F2, #7B6FE8);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        display: block;
    }

    .hero-subtitle {
        font-size: 16px;
        line-height: 1.6;
        color: var(--text-soft);
        max-width: 500px;
        margin: 0 auto 28px;
    }

    .hero-cta {
        display: flex;
        gap: 14px;
        justify-content: center;
        flex-wrap: wrap;
        margin-bottom: 36px;
    }

    .trust-indicators {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 24px;
        flex-wrap: wrap;
        margin-bottom: 50px;
        opacity: 0.85;
    }
    .trust-label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }
    .trust-logos { display: flex; gap: 24px; flex-wrap: wrap; align-items: center; }
    .trust-logo {
        font-family: var(--font-serif);
        font-style: italic;
        font-size: 16px;
        color: var(--text-soft);
        opacity: 0.65;
        transition: all 0.3s ease;
        font-weight: 500;
    }
    .trust-logo:hover { opacity: 0.95; transform: translateY(-1px); }

    /* ═══ PHONE MOCKUP ═══ */
    .mockup-stage {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: flex-end;
        gap: 10px;
        height: 480px;
    }
    .phone {
        background: white;
        border-radius: 36px;
        padding: 5px;
        box-shadow: 0 20px 60px rgba(30,58,95,0.18);
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .phone-main {
        width: 220px;
        height: 450px;
        z-index: 2;
        position: relative;
        animation: floatMain 4s ease-in-out infinite;
    }
    .phone-side {
        width: 150px;
        height: 340px;
        opacity: 0.92;
    }
    .phone-side-left {
        transform: rotate(-8deg) translate(20px, 20px);
        animation: floatLeft 5s ease-in-out infinite;
    }
    .phone-side-right {
        transform: rotate(8deg) translate(-20px, 20px);
        animation: floatRight 5s ease-in-out infinite 0.5s;
    }
    @keyframes floatMain {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
    @keyframes floatLeft {
        0%, 100% { transform: rotate(-8deg) translate(20px, 20px); }
        50% { transform: rotate(-8deg) translate(20px, 10px); }
    }
    @keyframes floatRight {
        0%, 100% { transform: rotate(8deg) translate(-20px, 20px); }
        50% { transform: rotate(8deg) translate(-20px, 10px); }
    }
    .phone:hover { transform: translateY(-8px) scale(1.02); }

    .phone-screen {
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, #F5F1FC, #E8E1F3);
        border-radius: 32px;
        padding: 18px 12px;
        display: flex;
        flex-direction: column;
        gap: 8px;
        position: relative;
        overflow: hidden;
    }
    .phone-status {
        font-size: 11px;
        color: var(--text-soft);
        text-align: center;
        font-weight: 600;
        margin-bottom: 4px;
    }
    .phone-label {
        font-size: 10px;
        color: var(--muted);
        text-align: center;
        margin-bottom: 4px;
        font-weight: 500;
    }
    .phone-card {
        background: rgba(255,255,255,0.95);
        border-radius: 14px;
        padding: 10px;
    }
    .phone-avatar {
        width: 100%;
        aspect-ratio: 1;
        border-radius: 12px;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        position: relative;
        overflow: hidden;
    }
    .phone-avatar::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(180deg, transparent 40%, rgba(0,0,0,0.15));
    }
    .phone-name {
        font-family: var(--font-serif);
        font-size: 17px;
        text-align: center;
        letter-spacing: -0.01em;
    }
    .phone-skill-tags {
        display: flex;
        gap: 4px;
        justify-content: center;
        margin-top: 6px;
        flex-wrap: wrap;
    }
    .phone-skill-tag {
        background: rgba(123,111,232,0.15);
        color: var(--purple-dark);
        padding: 2px 8px;
        border-radius: 100px;
        font-size: 9px;
        font-weight: 600;
    }

    /* ═══ STATS ═══ */
    .stats { padding: 20px; margin-top: -20px; }
    .stats-bar {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 24px;
        padding: 28px 40px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.06);
    }
    .stat-item { text-align: center; border-right: 1px solid rgba(30,58,95,0.08); }
    .stat-item:last-child { border-right: none; }
    .stat-value {
        font-family: var(--font-serif);
        font-size: 36px;
        font-weight: 400;
        color: var(--text);
        line-height: 1;
        letter-spacing: -0.02em;
        margin-bottom: 4px;
    }
    .stat-value em { font-style: italic; color: var(--purple); }
    .stat-label {
        font-size: 11px;
        color: var(--muted);
        font-weight: 500;
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }

    /* ═══ SECTIONS ═══ */
    .section {
         padding: 70px 20px;
        position: relative;
        z-index: 1;
        clear: both;
    }
    .section-header { text-align: center; max-width: 640px; margin: 0 auto 40px; }
    .section-eyebrow {
        display: inline-block;
        font-size: 11px;
        color: var(--purple);
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        margin-bottom: 10px;
    }
    .section-title {
        font-family: var(--font-serif);
        font-size: clamp(36px, 5vw, 52px);
        font-weight: 400;
        line-height: 1.1;
        letter-spacing: -0.02em;
        margin-bottom: 12px;
    }
    .section-title em { font-style: italic; color: var(--purple); }
    .section-subtitle {
        font-size: 15px;
        line-height: 1.6;
        color: var(--muted);
        max-width: 480px;
        margin: 0 auto;
    }

    /* ═══ CATEGORIES ═══ */
    .cat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
        max-width: 960px;
        margin: 0 auto;
    }
    .cat-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 20px 16px;
        text-align: center;
        text-decoration: none;
        color: var(--text);
        transition: all 0.3s;
        cursor: pointer;
    }
    .cat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.1);
        border-color: var(--purple);
    }
    .cat-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, var(--lav-2), var(--lav-3));
        border-radius: 14px;
        margin: 0 auto 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        transition: transform 0.3s;
    }
    .cat-card:hover .cat-icon { transform: scale(1.1) rotate(-5deg); }
    .cat-name { font-family: var(--font-serif); font-size: 16px; margin-bottom: 2px; }
    .cat-count { font-size: 11px; color: var(--muted); font-weight: 500; }

    /* ═══ COURSES ═══ */
    .courses-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .course-card {
        background: rgba(255,255,255,0.85);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(123,111,232,0.08);
        border-radius: 20px;
        overflow: hidden;
        text-decoration: none;
        color: var(--text);
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
    }
    .course-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.14), 0 8px 20px rgba(123,111,232,0.08);
        border-color: rgba(123,111,232,0.2);
    }
    .course-thumb {
        aspect-ratio: 16/10;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 60px;
    }
    .course-thumb-1 { background: linear-gradient(135deg, #667EEA, #764BA2); }
    .course-thumb-2 { background: linear-gradient(135deg, #F093FB, #F5576C); }
    .course-thumb-3 { background: linear-gradient(135deg, #4FACFE, #00F2FE); }
    .course-thumb-4 { background: linear-gradient(135deg, #FA709A, #FEE140); }
    .course-thumb-5 { background: linear-gradient(135deg, #30CFD0, #330867); }
    .course-thumb-6 { background: linear-gradient(135deg, #A8EDEA, #FED6E3); }

    .course-badge {
        position: absolute;
        top: 12px;
        left: 12px;
        padding: 4px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        backdrop-filter: blur(10px);
    }
    .badge-new { background: rgba(255,138,91,0.9); color: white; }
    .badge-bestseller { background: rgba(255,200,50,0.95); color: #5A3A00; }
    .badge-free { background: rgba(0,200,150,0.9); color: white; }

    .course-body { padding: 18px; }
    .course-category {
        font-size: 10px;
        color: var(--muted);
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        margin-bottom: 8px;
    }
    .course-title {
        font-family: var(--font-serif);
        font-size: 18px;
        line-height: 1.2;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .course-instructor {
        font-size: 12px;
        color: var(--text-soft);
        margin-bottom: 12px;
    }
    .course-meta {
        display: flex;
        gap: 12px;
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 14px;
        padding-bottom: 14px;
        border-bottom: 1px solid rgba(0,0,0,0.06);
    }
    .course-footer { display: flex; justify-content: space-between; align-items: center; }
    .course-price {
        font-family: var(--font-serif);
        font-size: 18px;
        font-weight: 400;
        letter-spacing: -0.01em;
        color: var(--text);
    }
    .course-price-free { color: var(--teal); font-weight: 600; }
    .course-arrow { font-size: 18px; color: var(--purple); transition: transform 0.3s; }
    .course-card:hover .course-arrow { transform: translateX(6px); color: var(--purple-dark); }

    @media (max-width: 768px) {
        .stats-bar { grid-template-columns: repeat(2, 1fr); padding: 20px; gap: 16px; }
        .stat-item { border-right: none; }
        .cat-grid { grid-template-columns: repeat(2, 1fr); }
        .courses-grid { grid-template-columns: 1fr; }
        .phone-side { display: none; }
        .mockup-stage { height: auto; }
        .trust-indicators { flex-direction: column; gap: 10px; }
    }
</style>
@endpush

@section('content')

{{-- ═══════════════════════════════════════════════════ --}}
{{-- HERO                                                 --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="hero">
    <div class="container">
        <div class="hero-badge">
            <span class="hero-badge-dot"></span>
            <span>{{ $studentCount ?? '50,000+' }} learners worldwide</span>
        </div>

        <h1 class="hero-title">
            Learn Anything,
            <em>Anytime</em>
        </h1>
        <p class="hero-subtitle">
            Master new skills with world-class instructors. Your personal learning journey starts here — free to begin, limitless to grow.
        </p>
        <div class="hero-cta">
            @guest
                <a href="{{ route('register') }}" class="btn btn-dark">Start Learning Free</a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @else
                <a href="{{ route('student.index') }}" class="btn btn-dark">Continue Learning </a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @endguest
        </div>

        <div class="trust-indicators">
            <span class="trust-label">Our alumni work at</span>
            <div class="trust-logos">
                <span class="trust-logo">Gojek</span>
                <span class="trust-logo">Tokopedia</span>
                <span class="trust-logo">Shopee</span>
                <span class="trust-logo">Traveloka</span>
                <span class="trust-logo">BCA</span>
            </div>
        </div>

        {{-- Phone Mockups --}}
        <div class="mockup-stage">
            {{-- Phone Left: Progress Tracker --}}
            <div class="phone phone-side phone-side-left">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Your Progress</div>
                    <div class="phone-card">
                        <div style="font-size:11px;font-weight:600;margin-bottom:4px;">Laravel Basics</div>
                        <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                            <div style="height:100%;width:75%;background:var(--purple);border-radius:2px;"></div>
                        </div>
                        <div style="font-size:9px;color:var(--muted);">75% · 12/16 lessons</div>
                    </div>
                    <div class="phone-card">
                        <div style="font-size:11px;font-weight:600;margin-bottom:4px;">UI/UX Basics</div>
                        <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                            <div style="height:100%;width:45%;background:var(--teal);border-radius:2px;"></div>
                        </div>
                        <div style="font-size:9px;color:var(--muted);">45% · 5/11 lessons</div>
                    </div>
                    <div class="phone-card">
                        <div style="font-size:11px;font-weight:600;margin-bottom:4px;">Python for Data</div>
                        <div style="height:4px;background:#E8E1F3;border-radius:2px;margin-bottom:3px;">
                            <div style="height:100%;width:90%;background:var(--orange);border-radius:2px;"></div>
                        </div>
                        <div style="font-size:9px;color:var(--muted);">90% · 18/20 lessons</div>
                    </div>
                </div>
            </div>

            {{-- Phone Main: Instructor --}}
            <div class="phone phone-main">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Featured Instructor</div>
                    <div class="phone-card">
                        <div class="phone-avatar">👨‍💻</div>
                        <div class="phone-name">Meet Andi</div>
                        <div style="font-size:10px;color:var(--muted);text-align:center;margin-top:2px;">Senior Developer · 12k students</div>
                        <div class="phone-skill-tags">
                            <span class="phone-skill-tag">Laravel</span>
                            <span class="phone-skill-tag">React</span>
                            <span class="phone-skill-tag">Node.js</span>
                        </div>
                    </div>
                    <div style="background:var(--purple);color:white;padding:8px 12px;border-radius:100px;font-size:11px;text-align:center;font-weight:600;">
                        Start Learning →
                    </div>
                </div>
            </div>

            {{-- Phone Right: Video Lesson --}}
            <div class="phone phone-side phone-side-right">
                <div class="phone-screen">
                    <div class="phone-status">9:41</div>
                    <div class="phone-label">Lesson 12</div>
                    <div class="phone-card">
                        <div style="aspect-ratio:16/10;background:linear-gradient(135deg,var(--navy),#2D4D7A);border-radius:8px;display:flex;align-items:center;justify-content:center;margin-bottom:6px;position:relative;">
                            <div style="width:30px;height:30px;background:white;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                                <span style="color:var(--navy);font-size:12px;">▶</span>
                            </div>
                        </div>
                        <div style="font-size:10px;font-weight:600;">Building Authentication</div>
                        <div style="font-size:9px;color:var(--muted);margin-top:2px;">⏱ 12:45 · Laravel Bootcamp</div>
                    </div>
                    <div class="phone-card" style="padding:8px;">
                        <div style="font-size:9px;color:var(--muted);margin-bottom:4px;">Up Next</div>
                        <div style="font-size:10px;font-weight:600;">Lesson 13: Middleware</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- STATS                                                --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="stats">
    <div class="container">
        <div class="stats-bar">
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['students'] ?? '50K+' }}</em></div>
                <div class="stat-label">Active Learners</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['courses'] ?? '500+' }}</em></div>
                <div class="stat-label">Courses</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['instructors'] ?? '120+' }}</em></div>
                <div class="stat-label">Expert Instructors</div>
            </div>
            <div class="stat-item">
                <div class="stat-value"><em>{{ $stats['satisfaction'] ?? '98%' }}</em></div>
                <div class="stat-label">Satisfaction Rate</div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- CATEGORIES                                           --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="categories">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Explore</span>
            <h2 class="section-title">Browse by <em>Category</em></h2>
            <p class="section-subtitle">Find your path among 500+ courses across every field you can imagine.</p>
        </div>

        <div class="cat-grid">
            @php
                $defaultCategories = [
    ['icon' => '<i class="fa-solid fa-code"></i>', 'name' => 'Programming', 'count' => 124, 'slug' => 'programming'],
    ['icon' => '<i class="fa-solid fa-pen-nib"></i>', 'name' => 'Design', 'count' => 87, 'slug' => 'design'],
    ['icon' => '<i class="fa-solid fa-briefcase"></i>', 'name' => 'Business', 'count' => 96, 'slug' => 'business'],
    ['icon' => '<i class="fa-solid fa-bullhorn"></i>', 'name' => 'Marketing', 'count' => 54, 'slug' => 'marketing'],
    ['icon' => '<i class="fa-solid fa-film"></i>', 'name' => 'Video & Film', 'count' => 38, 'slug' => 'video'],
    ['icon' => '<i class="fa-solid fa-language"></i>', 'name' => 'Languages', 'count' => 42, 'slug' => 'languages'],
    ['icon' => '<i class="fa-solid fa-music"></i>', 'name' => 'Music', 'count' => 29, 'slug' => 'music'],
    ['icon' => '<i class="fa-solid fa-chart-bar"></i>', 'name' => 'Data Science', 'count' => 67, 'slug' => 'data-science'],
];
                $categoriesData = $categories ?? $defaultCategories;
            @endphp

            @foreach($categoriesData as $cat)
                <a href="{{ route('courses.index') }}?category={{ $cat['slug'] ?? Str::slug($cat['name']) }}" class="cat-card">
                    <div class="cat-icon">{!! $cat['icon'] ?? '<i class="fa-solid fa-book-open"></i>' !!}</div>
                    <div class="cat-name">{{ $cat['name'] }}</div>
                    <div class="cat-count">{{ $cat['count'] }} courses</div>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- FEATURED COURSES                                     --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="courses">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow"></span>
            <h2 class="section-title">Most Popular <em>Courses</em></h2>
            <p class="section-subtitle">Join thousands of learners mastering these in-demand skills.</p>
        </div>

        <div class="courses-grid">
            @php
                $defaultCourses = [
                    ['icon' => '💻', 'title' => 'Fullstack Web Development with Laravel', 'category' => 'Programming', 'instructor' => 'Andi Saputra · Senior Dev @ Gojek', 'rating' => '4.9', 'students' => '12.3k', 'duration' => '40h', 'price' => 'Rp 299k', 'badge' => 'bestseller', 'thumb' => 1],
                    ['icon' => '🎨', 'title' => 'UI/UX Design Fundamentals for Beginners', 'category' => 'Design', 'instructor' => 'Sari Dewi · UX Lead @ Traveloka', 'rating' => '4.8', 'students' => '8.1k', 'duration' => '25h', 'price' => 'Rp 199k', 'badge' => 'new', 'thumb' => 2],
                    ['icon' => '📊', 'title' => 'Introduction to Python for Data Analysis', 'category' => 'Data Science', 'instructor' => 'Rio Ahmad · Data Sci @ Shopee', 'rating' => '4.9', 'students' => '15.7k', 'duration' => '20h', 'price' => 'Free', 'badge' => 'free', 'thumb' => 3],
                    ['icon' => '📈', 'title' => 'Digital Marketing Mastery 2025', 'category' => 'Marketing', 'instructor' => 'Maya Putri · CMO @ Tokopedia', 'rating' => '4.7', 'students' => '9.8k', 'duration' => '30h', 'price' => 'Rp 249k', 'badge' => 'bestseller', 'thumb' => 4],
                    ['icon' => '🚀', 'title' => 'Startup Fundamentals: From Idea to Launch', 'category' => 'Business', 'instructor' => 'Budi Hartono · Founder @ Techstars', 'rating' => '4.8', 'students' => '5.2k', 'duration' => '18h', 'price' => 'Rp 349k', 'badge' => 'new', 'thumb' => 5],
                    ['icon' => '✏️', 'title' => 'Master Your Time: Productivity for Beginners', 'category' => 'Productivity', 'instructor' => 'Linda Sari · Coach @ YCombinator', 'rating' => '4.9', 'students' => '22k', 'duration' => '8h', 'price' => 'Free', 'badge' => 'free', 'thumb' => 6],
                ];
                $coursesData = $featuredCourses ?? $defaultCourses;
            @endphp

            @foreach($coursesData as $course)
                <a href="{{ isset($course['slug']) ? route('courses.show', $course['slug']) : route('courses.index') }}" class="course-card">
                    <div class="course-thumb course-thumb-{{ $course['thumb'] ?? 1 }}">
                        @if(!empty($course['badge']))
                            <span class="course-badge badge-{{ $course['badge'] }}">
                                {{ $course['badge'] === 'bestseller' ? 'Bestseller' : ucfirst($course['badge']) }}
                            </span>
                        @endif
                        @if(!empty($course['thumbnail_url']))
    <img src="{{ $course['thumbnail_url'] }}" alt="{{ $course['title'] }}"
        style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover;opacity:0.85;">
@else
    {!! $course['icon'] ?? '<i class="fa-solid fa-book-open"></i>' !!}
@endif
                    </div>
                    <div class="course-body">
                        <div class="course-category">{{ $course['category'] }}</div>
                        <div class="course-title">{{ $course['title'] }}</div>
                        <div class="course-instructor">{{ $course['instructor'] }}</div>
                        <div class="course-meta">
                            <span>⭐ {{ $course['rating'] }}</span>
                            <span>👥 {{ $course['students'] }}</span>
                            <span>🕐 {{ $course['duration'] }}</span>
                        </div>
                        <div class="course-footer">
                            <div class="course-price {{ $course['price'] === 'Free' ? 'course-price-free' : '' }}">
                                {{ $course['price'] }}
                            </div>
                            <div class="course-arrow">→</div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div style="text-align:center;margin-top:32px;">
            <a href="{{ route('courses.index') }}" class="btn btn-light">View All 500+ Courses →</a>
        </div>
    </div>
</section>


{{-- ═══════════════════════════════════════════════════ --}}
{{-- Tambahan CSS untuk sisa section                     --}}
{{-- ═══════════════════════════════════════════════════ --}}
@push('styles')
<style>
    /* ═══ HOW IT WORKS ═══ */
    .how-section { padding: 60px 20px; }
    .how-wrapper {
        background: rgba(255,255,255,0.5);
        backdrop-filter: blur(30px);
        border: 1px solid rgba(255,255,255,0.8);
        border-radius: 32px;
        padding: 60px 40px;
        box-shadow: 0 10px 40px rgba(30,58,95,0.05);
    }
    .how-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
    }
    .how-card {
        background: white;
        border: 1px solid rgba(123,111,232,0.08);
        border-radius: 20px;
        padding: 28px 22px 24px;
        text-align: center;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    }
    .how-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.1);
        border-color: var(--purple);
    }
    .how-number {
        font-family: var(--font-serif);
        font-size: 48px;
        font-weight: 400;
        line-height: 1;
        margin-bottom: 18px;
        color: var(--text);
    }
    .how-visual {
        aspect-ratio: 3/2;
        background: linear-gradient(135deg, var(--lav-1), var(--lav-2));
        border-radius: 14px;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 16px;
        gap: 4px;
    }
    .avatar-stack { display: flex; }
    .avatar-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        margin-left: -10px;
        transition: transform 0.3s;
    }
    .avatar-circle:first-child { margin-left: 0; }
    .how-card:hover .avatar-circle:nth-child(1) { transform: translateX(-4px); }
    .how-card:hover .avatar-circle:nth-child(3) { transform: translateX(4px); }
    .wave-viz { display: flex; align-items: center; gap: 3px; }
    .wave-bar {
        width: 4px;
        background: var(--purple);
        border-radius: 100px;
        animation: waveBar 1.2s ease-in-out infinite;
    }
    @keyframes waveBar {
        0%, 100% { transform: scaleY(0.4); }
        50% { transform: scaleY(1); }
    }
    .cert-viz {
        width: 80px;
        height: 60px;
        background: linear-gradient(135deg, white, var(--lav-1));
        border-radius: 8px;
        border: 2px solid var(--purple);
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .cert-viz::after { content: '🏆'; font-size: 28px; }
    .how-title {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .how-desc { font-size: 12px; color: var(--muted); line-height: 1.6; }

    /* ═══ WHY US ═══ */
    .why-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        grid-auto-rows: 1fr;
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
        align-items: stretch;
    }
    .why-card {
        background: rgba(255,255,255,0.65);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 24px;
        padding: 28px;
        box-shadow: 0 4px 20px rgba(30,58,95,0.04);
        transition: all 0.3s;
        display: flex;             /* ← Tambah ini */
        flex-direction: column;    /* ← Tambah ini: arrange vertical */
        min-width: 0;              /* ← Tambah ini: prevent overflow */
        overflow: hidden;
    }
    .why-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 32px rgba(30,58,95,0.08);
    }
    .why-visual {
        aspect-ratio: 16/10;
        background: linear-gradient(135deg, var(--lav-1), white);
        border-radius: 16px;
        margin-bottom: 20px;
        padding: 16px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        justify-content: center;
        flex-shrink: 0; /* ← Tambah ini: prevent shrinking */
        overflow: hidden; /* ← Tambah ini: hide overflow */
    }
    .chat-bubble {
        background: white;
        padding: 8px 12px;
        border-radius: 14px;
        font-size: 11px;
        max-width: 75%;
        color: var(--text-soft);
        box-shadow: 0 2px 6px rgba(30,58,95,0.05);
        line-height: 1.4;
    }
    .chat-bubble-right {
        margin-left: auto;
        background: var(--purple);
        color: white;
    }
    .why-visual-center {
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        gap: 8px;
    }
    .why-viz-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--navy);
        color: white;
        padding: 8px 16px;
        border-radius: 100px;
        font-size: 11px;
        font-weight: 600;
    }
    .why-viz-title { font-family: var(--font-serif); font-size: 26px; letter-spacing: -0.01em; }
    .why-tags-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        justify-content: center;
        padding: 20px;
        align-items: center;
    }
    .why-tag {
        background: white;
        padding: 6px 12px;
        border-radius: 100px;
        font-size: 11px;
        color: var(--text-soft);
        font-weight: 500;
        box-shadow: 0 2px 6px rgba(30,58,95,0.05);
        transition: all 0.2s;
    }
    .why-tag:hover {
        background: var(--purple);
        color: white;
        transform: translateY(-2px);
    }
    .why-cert-visual {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }
    .cert-card {
        width: 140px;
        background: white;
        border: 2px solid var(--purple);
        border-radius: 10px;
        padding: 12px;
        text-align: center;
        transform: rotate(-3deg);
        box-shadow: 0 8px 20px rgba(30,58,95,0.1);
    }
    .cert-card::before {
        content: '🏆';
        font-size: 28px;
        display: block;
        margin-bottom: 6px;
    }
    .why-title {
        font-family: var(--font-serif);
        font-size: 24px;
        font-weight: 400;
        margin-bottom: 8px;
        letter-spacing: -0.01em;
    }
    .why-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

    /* ═══ INSTRUCTORS ═══ */
    .instructor-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 960px;
        margin: 0 auto;
    }
    .instructor-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 24px;
        text-align: center;
        transition: all 0.3s;
    }
    .instructor-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    }
    .instructor-avatar {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        margin: 0 auto 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        border: 3px solid white;
        box-shadow: 0 4px 14px rgba(30,58,95,0.15);
    }
    .instructor-name { font-family: var(--font-serif); font-size: 20px; margin-bottom: 4px; }
    .instructor-title { font-size: 11px; color: var(--muted); margin-bottom: 12px; }
    .instructor-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 4px;
        justify-content: center;
        margin-bottom: 14px;
    }
    .instructor-tag {
        background: rgba(123,111,232,0.1);
        color: var(--purple-dark);
        padding: 3px 10px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 600;
    }
    .instructor-stats {
        display: flex;
        gap: 12px;
        justify-content: center;
        font-size: 11px;
        color: var(--muted);
        padding-top: 14px;
        border-top: 1px solid rgba(0,0,0,0.08);
    }

    /* ═══ TESTIMONIALS ═══ */
    .testimonial-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
        max-width: 1000px;
        margin: 0 auto;
    }
    .testimonial-card {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 20px;
        padding: 24px;
        transition: all 0.3s;
    }
    .testimonial-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 30px rgba(30,58,95,0.08);
    }
    .testimonial-stars {
        color: #FFC452;
        font-size: 16px;
        margin-bottom: 12px;
        letter-spacing: 2px;
    }
    .testimonial-quote {
        font-family: var(--font-serif);
        font-size: 16px;
        line-height: 1.5;
        color: var(--text);
        margin-bottom: 20px;
        letter-spacing: -0.01em;
    }
    .testimonial-author {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .testimonial-avatar {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .testimonial-name { font-size: 13px; font-weight: 600; }
    .testimonial-role { font-size: 11px; color: var(--muted); }

    /* ═══ PRICING ═══ */
    .pricing-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 14px;
        max-width: 900px;
        margin: 0 auto;
    }
    .pricing-card {
        background: rgba(255,255,255,0.75);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.95);
        border-radius: 24px;
        padding: 28px 22px;
        position: relative;
        transition: all 0.3s;
        box-shadow: 0 4px 16px rgba(30,58,95,0.04);
    }
    .pricing-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 36px rgba(30,58,95,0.1);
    }
    .pricing-featured {
        background: linear-gradient(180deg, #9A8EE8, #7B6FE8);
        color: white;
        border: 1px solid rgba(255,255,255,0.3);
        box-shadow: 0 16px 40px rgba(123,111,232,0.35);
        transform: scale(1.03);
    }
    .pricing-featured:hover {
        transform: scale(1.03) translateY(-4px);
    }
    .pricing-badge {
        position: absolute;
        top: -10px;
        right: 20px;
        background: white;
        color: var(--text);
        padding: 5px 14px;
        border-radius: 100px;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.05em;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    .pricing-plan {
        font-family: var(--font-serif);
        font-size: 22px;
        font-weight: 400;
        margin-bottom: 4px;
    }
    .pricing-price {
        font-family: var(--font-serif);
        font-size: 44px;
        font-weight: 400;
        line-height: 1;
        letter-spacing: -0.02em;
        margin: 10px 0 4px;
    }
    .pricing-price-sub {
        font-size: 12px;
        color: var(--muted);
        font-weight: 500;
        margin-left: 2px;
    }
    .pricing-featured .pricing-price-sub { color: rgba(255,255,255,0.8); }
    .pricing-desc {
        font-size: 12px;
        color: var(--muted);
        margin-bottom: 20px;
        padding-bottom: 20px;
        border-bottom: 1px solid rgba(0,0,0,0.08);
        line-height: 1.5;
        min-height: 40px;
    }
    .pricing-featured .pricing-desc {
        color: rgba(255,255,255,0.85);
        border-bottom-color: rgba(255,255,255,0.2);
    }
    .pricing-features {
        list-style: none;
        margin-bottom: 20px;
        min-height: 150px;
    }
    .pricing-features li {
        font-size: 12px;
        padding: 4px 0;
        color: var(--text-soft);
        display: flex;
        align-items: flex-start;
        gap: 8px;
        line-height: 1.5;
    }
    .pricing-featured .pricing-features li { color: rgba(255,255,255,0.95); }
    .pricing-features li::before {
        content: '✓';
        color: var(--purple);
        font-weight: 700;
        flex-shrink: 0;
    }
    .pricing-featured .pricing-features li::before { color: white; }
    .pricing-btn {
        width: 100%;
        background: rgba(0,0,0,0.06);
        color: var(--text);
        border: none;
        padding: 11px;
        border-radius: 100px;
        font-weight: 500;
        font-size: 13px;
        cursor: pointer;
        font-family: var(--font-sans);
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .pricing-btn:hover {
        background: rgba(0,0,0,0.1);
        transform: translateY(-1px);
    }
    .pricing-featured .pricing-btn {
        background: white;
        color: var(--purple-dark);
        font-weight: 600;
    }
    .pricing-featured .pricing-btn:hover {
        background: rgba(255,255,255,0.9);
    }

    /* ═══ SDG ═══ */
    .sdg-wrapper {
        background: linear-gradient(135deg, var(--navy), #2D4D7A);
        border-radius: 32px;
        padding: 60px 40px;
        color: white;
        position: relative;
        overflow: hidden;
        max-width: 1100px;
        margin: 0 auto;
    }
    .sdg-wrapper::before {
        content: '';
        position: absolute;
        top: -100px;
        right: -100px;
        width: 400px;
        height: 400px;
        background: radial-gradient(circle, rgba(184,175,235,0.3), transparent 70%);
    }
    .sdg-content { position: relative; z-index: 1; }
    .sdg-eyebrow {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--lav-4);
        margin-bottom: 12px;
        text-align: center;
    }
    .sdg-title {
        font-family: var(--font-serif);
        font-size: clamp(32px, 4vw, 42px);
        font-weight: 400;
        text-align: center;
        line-height: 1.2;
        letter-spacing: -0.02em;
        margin-bottom: 14px;
    }
    .sdg-subtitle {
        text-align: center;
        color: rgba(255,255,255,0.8);
        font-size: 14px;
        max-width: 540px;
        margin: 0 auto 40px;
        line-height: 1.6;
    }
    .sdg-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    .sdg-card {
        background: rgba(255,255,255,0.08);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.15);
        border-radius: 20px;
        padding: 28px 24px;
        transition: all 0.3s;
    }
    .sdg-card:hover {
        background: rgba(255,255,255,0.15);
        transform: translateY(-4px);
    }
    .sdg-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 60px;
        background: rgba(255,255,255,0.95);
        color: var(--navy);
        font-family: var(--font-serif);
        font-size: 28px;
        border-radius: 14px;
        margin-bottom: 16px;
    }
    .sdg-name {
        font-family: var(--font-serif);
        font-size: 20px;
        margin-bottom: 6px;
        letter-spacing: -0.01em;
    }
    .sdg-code {
        display: inline-block;
        font-size: 10px;
        color: var(--lav-4);
        font-weight: 700;
        letter-spacing: 0.1em;
        margin-bottom: 12px;
    }
    .sdg-desc {
        font-size: 13px;
        color: rgba(255,255,255,0.8);
        line-height: 1.6;
    }

    /* ═══ FAQ ═══ */
    .faq-wrapper { max-width: 720px; margin: 0 auto; }
    .faq-item {
        background: rgba(255,255,255,0.7);
        backdrop-filter: blur(20px);
        border: 1px solid rgba(255,255,255,0.9);
        border-radius: 16px;
        margin-bottom: 10px;
        overflow: hidden;
        transition: all 0.3s;
    }
    .faq-item:hover { border-color: var(--purple); }
    .faq-question {
        width: 100%;
        background: transparent;
        border: none;
        padding: 18px 22px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-family: var(--font-sans);
        font-size: 15px;
        font-weight: 500;
        text-align: left;
        cursor: pointer;
        color: var(--text);
        transition: all 0.2s;
    }
    .faq-question:hover { color: var(--purple); }
    .faq-icon {
        width: 24px;
        height: 24px;
        border-radius: 50%;
        background: rgba(123,111,232,0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--purple);
        font-size: 14px;
        flex-shrink: 0;
        transition: transform 0.3s;
    }
    .faq-item.active .faq-icon {
        transform: rotate(45deg);
        background: var(--purple);
        color: white;
    }
    .faq-answer {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.4s ease, padding 0.4s ease;
    }
    .faq-answer-inner {
        padding: 0 22px 20px;
        font-size: 14px;
        color: var(--muted);
        line-height: 1.7;
    }
    .faq-item.active .faq-answer { max-height: 300px; }

    /* ═══ CTA ═══ */
    .cta {
        text-align: center;
        padding: 100px 20px 40px;
    }
    .cta-title {
        font-family: var(--font-serif);
        font-size: clamp(36px, 5vw, 52px);
        font-weight: 400;
        line-height: 1.15;
        letter-spacing: -0.02em;
        margin-bottom: 28px;
        max-width: 640px;
        margin-left: auto;
        margin-right: auto;
    }
    .cta-title em { font-style: italic; color: var(--purple); }

    @media (max-width: 768px) {
        .how-grid, .why-grid, .instructor-grid,
        .testimonial-grid, .pricing-grid, .sdg-grid { grid-template-columns: 1fr; }
        .pricing-featured { transform: none; }
        .how-wrapper, .sdg-wrapper { padding: 40px 24px; }
    }
</style>
@endpush

{{-- ═══════════════════════════════════════════════════ --}}
{{-- HOW IT WORKS                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="how-section" id="how">
    <div class="container">
        <div class="how-wrapper">
            <div class="section-header">
                <span class="section-eyebrow"></span>
                <h2 class="section-title">How It <em>Works</em></h2>
                <p class="section-subtitle">Three simple steps to start your learning journey today.</p>
            </div>

            <div class="how-grid">
                <div class="how-card">
                    <div class="how-number">1</div>
                    <div class="how-visual">
                        <div class="avatar-stack">
                            <div class="avatar-circle" style="background:linear-gradient(135deg,#7B6FE8,#B8AFEB);">👨‍💻</div>
                            <div class="avatar-circle" style="background:linear-gradient(135deg,#FF8A5B,#FFA07A);">👩‍🎨</div>
                            <div class="avatar-circle" style="background:linear-gradient(135deg,#00C896,#00E6B0);">👨‍🔬</div>
                        </div>
                    </div>
                    <div class="how-title">Choose Your<br>Path</div>
                    <p class="how-desc">Browse 500+ courses across programming, design, business, and more. Find the skill that matches your goals.</p>
                </div>

                <div class="how-card">
                    <div class="how-number">2</div>
                    <div class="how-visual">
                        <div class="wave-viz">
                            <div class="wave-bar" style="height:12px;animation-delay:0s;"></div>
                            <div class="wave-bar" style="height:24px;animation-delay:0.1s;"></div>
                            <div class="wave-bar" style="height:36px;animation-delay:0.2s;"></div>
                            <div class="wave-bar" style="height:48px;animation-delay:0.3s;"></div>
                            <div class="wave-bar" style="height:36px;animation-delay:0.4s;"></div>
                            <div class="wave-bar" style="height:24px;animation-delay:0.5s;"></div>
                            <div class="wave-bar" style="height:12px;animation-delay:0.6s;"></div>
                        </div>
                    </div>
                    <div class="how-title">Learn at<br>Your Pace</div>
                    <p class="how-desc">Watch video lessons, complete exercises, and get instant feedback. Study anytime from any device.</p>
                </div>

                <div class="how-card">
                    <div class="how-number">3</div>
                    <div class="how-visual">
                        <div class="cert-viz"></div>
                    </div>
                    <div class="how-title">Earn Your<br>Certificate</div>
                    <p class="how-desc">Complete the course and receive a verified certificate you can showcase on LinkedIn and your CV.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- WHY COURSIFY                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow"></span>
            <h2 class="section-title">Why <em>Coursify</em>&nbsp;?</h2>
            <p class="section-subtitle">Everything you need to master new skills in one beautifully designed platform.</p>
        </div>

        <div class="why-grid">
            <div class="why-card">
                <div class="why-visual">
                    <div class="chat-bubble">Can you explain how Laravel middleware works?</div>
                    <div class="chat-bubble chat-bubble-right">Great question! Middleware acts as a filter for HTTP requests...</div>
                    <div class="chat-bubble">Oh I get it now, thank you!</div>
                </div>
                <div class="why-title">Expert Instructors</div>
                <p class="why-desc">Learn from industry professionals with real-world experience. All instructors are verified and rated by students.</p>
            </div>

            <div class="why-card">
                <div class="why-visual why-visual-center">
                    <div class="why-viz-badge">
                        <span style="width:6px;height:6px;background:var(--teal);border-radius:50%;animation:pulse 2s infinite;"></span>
                        Always Available
                    </div>
                    <div class="why-viz-title">24/7 Learning</div>
                    <div style="font-size:11px;color:var(--muted);">Study on your own schedule</div>
                </div>
                <div class="why-title">Learn Anytime</div>
                <p class="why-desc">No deadlines, no pressure. Watch lessons, pause, rewind — study whenever it fits your schedule.</p>
            </div>

            <div class="why-card">
                <div class="why-visual why-cert-visual">
                    <div class="cert-card">
                        <div style="font-size:10px;color:var(--muted);margin-bottom:2px;">CERTIFICATE</div>
                        <div style="font-family:var(--font-serif);font-size:12px;">of Completion</div>
                        <div style="font-size:9px;color:var(--muted);margin-top:4px;">Verified ID: #CRS-2025</div>
                    </div>
                </div>
                <div class="why-title">Verified Certificates</div>
                <p class="why-desc">Earn official digital certificates upon completion. Shareable on LinkedIn and verifiable by employers worldwide.</p>
            </div>

            <div class="why-card">
                <div class="why-visual why-tags-wrap">
                    <div class="why-tag">💻 Code Review</div>
                    <div class="why-tag">💬 Q&A Forum</div>
                    <div class="why-tag">🎯 Projects</div>
                    <div class="why-tag">📚 Study Groups</div>
                    <div class="why-tag">🏆 Leaderboard</div>
                </div>
                <div class="why-title">Vibrant Community</div>
                <p class="why-desc">Join 50,000+ learners. Ask questions, share projects, and grow together with peers worldwide.</p>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- INSTRUCTORS                                          --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Meet Our Experts</span>
            <h2 class="section-title">Learn from the <em>Best</em></h2>
            <p class="section-subtitle">Our instructors are industry veterans from top Indonesian tech companies.</p>
        </div>

        <div class="instructor-grid">
            @php
                $defaultInstructors = [
                    ['avatar' => '👨‍💻', 'name' => 'Budi Santoso', 'title' => 'Senior Dev @ Tokopedia', 'tags' => ['Laravel', 'React', 'AWS'], 'courses' => '45', 'students' => '120K'],
                    ['avatar' => '👩‍🎨', 'name' => 'Sari Dewi', 'title' => 'UX Lead @ Traveloka', 'tags' => ['UI/UX', 'Figma', 'Research'], 'courses' => '12', 'students' => '38K'],
                    ['avatar' => '👨‍🔬', 'name' => 'Rio Ahmad', 'title' => 'Data Scientist @ Shopee', 'tags' => ['Python', 'ML', 'Analytics'], 'courses' => '28', 'students' => '67K'],
                ];
                $instructorsData = $instructors ?? $defaultInstructors;
            @endphp

            @foreach($instructorsData as $inst)
                <div class="instructor-card">
                    <div class="instructor-avatar">{{ $inst['avatar'] }}</div>
                    <div class="instructor-name">{{ $inst['name'] }}</div>
                    <div class="instructor-title">{{ $inst['title'] }}</div>
                    <div class="instructor-tags">
                        @foreach($inst['tags'] as $tag)
                            <span class="instructor-tag">{{ $tag }}</span>
                        @endforeach
                    </div>
                    <div class="instructor-stats">
                        <span>📚 {{ $inst['courses'] }} courses</span>
                        <span>👥 {{ $inst['students'] }} students</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- TESTIMONIALS                                         --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Student Stories</span>
            <h2 class="section-title">Loved by <em>Learners</em></h2>
            <p class="section-subtitle">Real stories from people who transformed their careers with Coursify.</p>
        </div>

        <div class="testimonial-grid">
            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Coursify helped me transition from marketing to frontend development in 6 months. The certificates were a game-changer for my CV!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">👨</div>
                    <div>
                        <div class="testimonial-name">Andi Pratama</div>
                        <div class="testimonial-role">Frontend Dev @ Gojek</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"The instructors are world-class. I learned more in 3 months on Coursify than a year of college. Highly recommended!"</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">👩</div>
                    <div>
                        <div class="testimonial-name">Putri Rahma</div>
                        <div class="testimonial-role">Data Analyst @ Shopee</div>
                    </div>
                </div>
            </div>

            <div class="testimonial-card">
                <div class="testimonial-stars">★★★★★</div>
                <p class="testimonial-quote">"Love the flexibility. I can study during my commute, at night, anytime. Finally platform that respects my schedule."</p>
                <div class="testimonial-author">
                    <div class="testimonial-avatar">👨</div>
                    <div>
                        <div class="testimonial-name">Dimas Wijaya</div>
                        <div class="testimonial-role">Product Manager</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- PRICING                                              --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section" id="pricing">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">Pricing</span>
            <h2 class="section-title">Start free.<br>Upgrade when <em>ready</em>.</h2>
            <p class="section-subtitle">Flexible plans that grow with you. Cancel anytime, no questions asked.</p>
        </div>

        <div class="pricing-grid">
            <div class="pricing-card">
                <div class="pricing-plan">Starter</div>
                <div class="pricing-price">Free</div>
                <div class="pricing-desc">Perfect for exploring and trying out the platform.</div>
                <ul class="pricing-features">
                    <li>Access to 100+ free courses</li>
                    <li>Basic progress tracking</li>
                    <li>Community forum access</li>
                    <li>Audit mode certificates</li>
                </ul>
                <a href="{{ route('register') }}" class="pricing-btn">Get Started</a>
            </div>

            <div class="pricing-card pricing-featured">
                <div class="pricing-badge">Most Popular</div>
                <div class="pricing-plan">Pro</div>
                <div class="pricing-price">Rp 99k<span class="pricing-price-sub">/month</span></div>
                <div class="pricing-desc">Full access to all premium courses and features.</div>
                <ul class="pricing-features">
                    <li>All 500+ premium courses</li>
                    <li>Verified certificates</li>
                    <li>Offline downloads</li>
                    <li>Priority support 24/7</li>
                    <li>1-on-1 mentoring sessions</li>
                </ul>
                <a href="{{ route('payment.index') }}?plan=pro" class="pricing-btn">Start Free Trial</a>
            </div>

            <div class="pricing-card">
                <div class="pricing-plan">Business</div>
                <div class="pricing-price">Rp 499k<span class="pricing-price-sub">/month</span></div>
                <div class="pricing-desc">For teams and companies investing in their people.</div>
                <ul class="pricing-features">
                    <li>Everything in Pro plan</li>
                    <li>Up to 25 team members</li>
                    <li>Admin dashboard</li>
                    <li>Analytics & reporting</li>
                    <li>Custom learning paths</li>
                </ul>
                <a href="{{ route('payment.index') }}?plan=business" class="pricing-btn">Contact Sales</a>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- SDG COMMITMENT                                       --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="sdg-wrapper">
            <div class="sdg-content">
                <div class="sdg-eyebrow">Sustainable Development Goals</div>
                <h2 class="sdg-title">Education for <em style="font-style:italic;">everyone</em>.<br>Growth for the <em style="font-style:italic;">future</em>.</h2>
                <p class="sdg-subtitle">Coursify is committed to supporting the United Nations Sustainable Development Goals through accessible, quality education.</p>

                <div class="sdg-grid">
                    <div class="sdg-card">
                        <div class="sdg-number">4</div>
                        <div class="sdg-code">SDG 4</div>
                        <div class="sdg-name">Quality Education</div>
                        <p class="sdg-desc">Providing free courses and scholarships for underserved communities. Lifelong learning for all.</p>
                    </div>

                    <div class="sdg-card">
                        <div class="sdg-number">8</div>
                        <div class="sdg-code">SDG 8</div>
                        <div class="sdg-name">Decent Work</div>
                        <p class="sdg-desc">Equipping 50K+ learners with industry-ready skills for better career opportunities.</p>
                    </div>

                    <div class="sdg-card">
                        <div class="sdg-number">10</div>
                        <div class="sdg-code">SDG 10</div>
                        <div class="sdg-name">Reduced Inequalities</div>
                        <p class="sdg-desc">Breaking educational barriers through accessible technology for everyone, everywhere.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- FAQ                                                  --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="section">
    <div class="container">
        <div class="section-header">
            <span class="section-eyebrow">FAQ</span>
            <h2 class="section-title">Frequently Asked<br><em>Questions</em></h2>
            <p class="section-subtitle">Can't find what you're looking for? Reach out to our support team.</p>
        </div>

        <div class="faq-wrapper" x-data="{ openFaq: null }">
            @php
                $faqs = [
                    ['q' => 'Are the certificates recognized by employers?', 'a' => 'Yes! Our certificates are issued by Coursify and our partner institutions. They include unique verification IDs that employers can verify online. Many of our alumni have landed jobs at top companies like Gojek, Tokopedia, and Shopee using these certificates.'],
                    ['q' => 'Can I access courses offline?', 'a' => 'Pro and Business plan subscribers can download lessons to our mobile app for offline viewing. This is perfect for learning during commutes or when you don\'t have internet access.'],
                    ['q' => 'What if I\'m not satisfied?', 'a' => 'We offer a 30-day money-back guarantee on all Pro subscriptions. If you\'re not happy for any reason, contact our support team for a full refund — no questions asked.'],
                    ['q' => 'Do you offer corporate packages?', 'a' => 'Absolutely. Our Business plan is designed for teams of up to 25 people. For larger enterprises, we offer custom packages with dedicated account managers, custom learning paths, and detailed analytics.'],
                    ['q' => 'Can I become an instructor?', 'a' => 'Yes! We\'re always looking for talented instructors. You need at least 3 years of industry experience and a portfolio of work. Apply through our instructor portal and our team will review your application within 7 days.'],
                ];
            @endphp

            @foreach($faqs as $index => $faq)
                <div class="faq-item" :class="{ 'active': openFaq === {{ $index }} }">
                    <button class="faq-question" @click="openFaq = openFaq === {{ $index }} ? null : {{ $index }}">
                        <span>{{ $faq['q'] }}</span>
                        <span class="faq-icon">+</span>
                    </button>
                    <div class="faq-answer">
                        <div class="faq-answer-inner">{{ $faq['a'] }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════════ --}}
{{-- CTA BIG                                              --}}
{{-- ═══════════════════════════════════════════════════ --}}
<section class="cta">
    <div class="container">
        <h2 class="cta-title">Everyone deserves to learn —<br><em>anytime, anywhere.</em></h2>
        <div class="hero-cta">
            @guest
                <a href="{{ route('register') }}" class="btn btn-dark">Start Learning Free</a>
                <a href="{{ route('courses.index') }}" class="btn btn-light">▶ Browse Courses</a>
            @else
                <a href="{{ route('courses.index') }}" class="btn btn-dark">Explore Courses →</a>
            @endguest
        </div>
    </div>
</section>

@endsection

{{-- ═══════════════════════════════════════════════════ --}}
{{-- JAVASCRIPT                                           --}}
{{-- ═══════════════════════════════════════════════════ --}}
@push('scripts')
<script>
    // Scroll reveal animation
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, { threshold: 0.1 });

    document.querySelectorAll('.section, .how-section, .stats').forEach(section => {
        section.style.opacity = '0';
        section.style.transform = 'translateY(20px)';
        section.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
        observer.observe(section);
    });

    // Count-up animation for stats
    const countUp = (el, target) => {
        let current = 0;
        const duration = 2000;
        const startTime = performance.now();
        const isK = target.includes('K');
        const isPlus = target.includes('+');
        const isPercent = target.includes('%');
        const num = parseFloat(target.replace(/[^\d.]/g, ''));

        const update = (now) => {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / duration, 1);
            current = num * progress;

            let display = Math.floor(current);
            if (isK) display = display + 'K';
            if (isPlus) display = display + '+';
            if (isPercent) display = display + '%';

            el.textContent = display;

            if (progress < 1) requestAnimationFrame(update);
            else el.textContent = target;
        };
        requestAnimationFrame(update);
    };

    const statsObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.querySelectorAll('.stat-value em').forEach(el => {
                    if (!el.dataset.counted) {
                        el.dataset.counted = 'true';
                        countUp(el, el.textContent);
                    }
                });
                statsObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('.stats-bar').forEach(el => statsObserver.observe(el));
</script>
@endpush