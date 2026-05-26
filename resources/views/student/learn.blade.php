<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $lesson->title }} — {{ $course->title }} — Coursify</title>

<link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

@vite(['resources/css/app.css', 'resources/js/app.js'])
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

<style>
:root {
    --navy: #153759;
    --navy-dark: #0F2744;
    --lav-1: #F5F1FC;
    --lav-2: #E8E1F3;
    --lav-3: #D4CDF0;
    --lav-4: #B8AFEB;
    --purple: #7B6FE8;
    --purple-dark: #5B4FD4;
    --teal: #00C896;
    --teal-light: #E6FBF5;
    --orange: #FF8A5B;
    --orange-light: #FFF0E8;
    --gold: #FFC452;
    --gold-light: #FFF7E0;
    --text: #1A1825;
    --text-soft: #4A4660;
    --muted: #8B87A8;
    --border: rgba(30,58,95,0.08);
    --font-serif: 'Instrument Serif', serif;
    --font-sans: 'Inter', sans-serif;
    --sidebar-w: 320px;
    --navbar-h: 72px;
}

*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }

body {
    font-family: var(--font-sans);
    color: var(--text);
    background: linear-gradient(180deg, #EDE5F9 0%, #D8CEEE 50%, #C4B8E8 100%);
    background-attachment: fixed;
    min-height: 100vh;
    -webkit-font-smoothing: antialiased;
    overflow-x: hidden;
}

body::before {
    content: '';
    position: fixed;
    inset: 0;
    background:
        radial-gradient(ellipse 800px 400px at 20% 10%, rgba(255,255,255,0.5), transparent),
        radial-gradient(ellipse 600px 300px at 80% 30%, rgba(255,255,255,0.4), transparent),
        radial-gradient(ellipse 700px 400px at 50% 90%, rgba(255,255,255,0.3), transparent);
    pointer-events: none;
    z-index: 0;
}

/* ═══ NAVBAR ═══ */
.navbar-wrap {
    position: fixed; top: 0; left: 0; right: 0; z-index: 200;
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(30px) saturate(180%);
    border-bottom: 1px solid rgba(255,255,255,0.9);
    box-shadow: 0 4px 24px rgba(30,58,95,0.08);
    height: var(--navbar-h);
    display: flex; align-items: center;
}
.navbar-inner {
    width: 100%; padding: 0 20px;
    display: flex; align-items: center; gap: 16px;
}
.logo {
    display: flex; align-items: center; gap: 10px;
    text-decoration: none; color: var(--text); flex-shrink: 0;
}
.logo-img { width: 32px; height: 32px; border-radius: 8px; object-fit: cover; }
.logo-text { font-size: 16px; font-weight: 700; letter-spacing: -0.02em; }
.navbar-divider {
    width: 1px; height: 24px;
    background: var(--border); flex-shrink: 0;
}
.navbar-course-title {
    font-size: 13px; font-weight: 600; color: var(--text-soft);
    flex: 1; min-width: 0;
    overflow: hidden; text-overflow: ellipsis; white-space: nowrap;
}
.navbar-progress-wrap {
    display: flex; align-items: center; gap: 10px; flex-shrink: 0;
}
.navbar-progress-bar {
    width: 120px; height: 6px;
    background: var(--lav-2); border-radius: 100px; overflow: hidden;
}
.navbar-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--teal), #00A075);
    border-radius: 100px; transition: width 0.5s ease;
}
.navbar-progress-pct {
    font-size: 12px; font-weight: 700; color: var(--teal);
    white-space: nowrap;
}
.btn-nav-outline {
    padding: 7px 16px;
    background: rgba(255,255,255,0.7);
    border: 1.5px solid var(--border);
    border-radius: 100px;
    font-size: 12px; font-weight: 600; color: var(--text-soft);
    text-decoration: none; transition: all 0.2s; flex-shrink: 0;
    white-space: nowrap;
}
.btn-nav-outline:hover { background: white; border-color: var(--purple); color: var(--purple); }
.btn-nav-dark {
    padding: 8px 18px; background: #1A1825; color: white;
    border-radius: 100px; text-decoration: none;
    font-size: 12px; font-weight: 600; transition: all 0.2s; flex-shrink: 0;
    white-space: nowrap;
}
.btn-nav-dark:hover { background: #2A2840; }

/* ═══ LAYOUT ═══ */
.learn-layout {
    display: block;
    min-height: 100vh;
    padding-top: var(--navbar-h);
    position: relative; z-index: 1;
}

/* ═══ SIDEBAR ═══ */
.learn-sidebar {
    position: fixed;
    top: var(--navbar-h);
    left: 0;
    width: var(--sidebar-w);
    height: calc(100vh - var(--navbar-h));
    overflow-y: auto;
    background: rgba(255,255,255,0.75);
    backdrop-filter: blur(30px);
    border-right: 1px solid rgba(255,255,255,0.9);
    z-index: 100;
    display: flex; flex-direction: column;
}
.learn-sidebar::-webkit-scrollbar { width: 4px; }
.learn-sidebar::-webkit-scrollbar-thumb { background: var(--lav-3); border-radius: 4px; }

.sidebar-header {
    padding: 20px 20px 16px;
    border-bottom: 1px solid var(--border);
    flex-shrink: 0;
}
.sidebar-course-label {
    font-size: 10px; font-weight: 700; color: var(--muted);
    letter-spacing: 0.1em; text-transform: uppercase; margin-bottom: 6px;
}
.sidebar-course-title {
    font-family: var(--font-serif); font-size: 16px; font-weight: 400;
    color: var(--text); line-height: 1.3; letter-spacing: -0.01em;
    margin-bottom: 14px;
}
.sidebar-progress-block { }
.sidebar-progress-label {
    display: flex; justify-content: space-between; align-items: center;
    font-size: 11px; color: var(--muted); font-weight: 600; margin-bottom: 6px;
}
.sidebar-progress-label span:last-child { color: var(--teal); }
.sidebar-progress-bar {
    height: 6px; background: var(--lav-2); border-radius: 100px; overflow: hidden;
}
.sidebar-progress-fill {
    height: 100%;
    background: linear-gradient(90deg, var(--teal), #00A075);
    border-radius: 100px; transition: width 0.5s ease;
}

.sidebar-sections { flex: 1; padding: 12px 0; }

.sidebar-section { margin-bottom: 4px; }
.sidebar-section-header {
    width: 100%; background: transparent; border: none;
    padding: 10px 20px; display: flex; align-items: center; gap: 10px;
    cursor: pointer; font-family: var(--font-sans); text-align: left;
    transition: background 0.2s;
}
.sidebar-section-header:hover { background: rgba(255,255,255,0.5); }
.sidebar-section-icon {
    width: 20px; height: 20px; border-radius: 6px;
    background: var(--lav-1); color: var(--purple);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; flex-shrink: 0; transition: all 0.3s;
    font-weight: 700;
}
.sidebar-section.open .sidebar-section-icon {
    background: var(--purple); color: white;
}
.sidebar-section-name {
    font-size: 12px; font-weight: 700; color: var(--text-soft);
    flex: 1; min-width: 0; line-height: 1.3;
}
.sidebar-section-count {
    font-size: 10px; color: var(--muted); font-weight: 500; flex-shrink: 0;
}
.sidebar-section-chevron {
    font-size: 10px; color: var(--muted); flex-shrink: 0;
    transition: transform 0.3s;
}
.sidebar-section.open .sidebar-section-chevron { transform: rotate(180deg); }

.sidebar-lessons {
    max-height: 0; overflow: hidden; transition: max-height 0.4s ease;
}
.sidebar-section.open .sidebar-lessons { max-height: 2000px; }

.sidebar-lesson {
    display: flex; align-items: center; gap: 10px;
    padding: 9px 20px 9px 32px;
    text-decoration: none; color: var(--text-soft);
    font-size: 12.5px; font-weight: 500; line-height: 1.4;
    transition: all 0.2s; border-left: 2px solid transparent;
    cursor: pointer;
}
.sidebar-lesson:hover {
    background: rgba(255,255,255,0.6);
    color: var(--text);
}
.sidebar-lesson.active {
    background: rgba(123,111,232,0.08);
    border-left-color: var(--purple);
    color: var(--purple-dark);
    font-weight: 600;
}
.sidebar-lesson.completed { color: var(--teal); }
.sidebar-lesson.completed .lesson-check { background: var(--teal); }

.lesson-check {
    width: 18px; height: 18px; border-radius: 50%;
    border: 1.5px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 9px; color: white; flex-shrink: 0;
    transition: all 0.2s;
}
.sidebar-lesson.active .lesson-check {
    border-color: var(--purple); background: var(--purple);
}
.sidebar-lesson.completed .lesson-check {
    border-color: var(--teal); background: var(--teal);
}
.lesson-num {
    font-size: 10px; color: var(--muted); font-weight: 700;
    flex-shrink: 0; min-width: 16px;
}
.lesson-label { flex: 1; min-width: 0; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

/* ═══ MAIN CONTENT ═══ */
.learn-main {
    margin-left: var(--sidebar-w);
    min-height: calc(100vh - var(--navbar-h));
    display: flex; flex-direction: column;
}

.learn-content { flex: 1; padding: 32px 40px; max-width: 900px; }

/* Breadcrumb */
.learn-breadcrumb {
    display: flex; align-items: center; gap: 8px;
    margin-bottom: 24px; flex-wrap: wrap;
}
.learn-breadcrumb a {
    font-size: 12px; color: var(--muted);
    text-decoration: none; font-weight: 500; transition: color 0.2s;
}
.learn-breadcrumb a:hover { color: var(--purple); }
.learn-breadcrumb-sep { font-size: 12px; color: var(--muted); opacity: 0.5; }
.learn-breadcrumb-current { font-size: 12px; color: var(--text); font-weight: 600; }

/* Lesson header */
.lesson-header { margin-bottom: 28px; }
.lesson-section-badge {
    display: inline-flex; align-items: center; gap: 5px;
    padding: 4px 12px; background: rgba(123,111,232,0.1);
    color: var(--purple-dark); border: 1px solid rgba(123,111,232,0.2);
    border-radius: 100px; font-size: 11px; font-weight: 700;
    letter-spacing: 0.03em; margin-bottom: 12px;
}
.lesson-title {
    font-family: var(--font-serif);
    font-size: clamp(26px, 3.5vw, 38px);
    font-weight: 400; line-height: 1.15;
    letter-spacing: -0.02em; color: var(--text);
    margin-bottom: 12px;
}
.lesson-meta {
    display: flex; gap: 16px; flex-wrap: wrap; align-items: center;
}
.lesson-meta-item {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; color: var(--muted); font-weight: 500;
}

/* Video embed */
.video-wrap {
    background: rgba(255,255,255,0.7);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px; overflow: hidden;
    margin-bottom: 28px;
    box-shadow: 0 10px 40px rgba(30,58,95,0.08);
}
.video-frame {
    aspect-ratio: 16/9; width: 100%;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    position: relative; display: flex; align-items: center; justify-content: center;
}
.video-frame iframe {
    position: absolute; inset: 0; width: 100%; height: 100%;
    border: none;
}
.video-placeholder {
    display: flex; flex-direction: column; align-items: center;
    gap: 14px; color: rgba(255,255,255,0.7); text-align: center; padding: 40px;
}
.video-placeholder-icon {
    width: 80px; height: 80px; border-radius: 50%;
    background: rgba(255,255,255,0.15);
    display: flex; align-items: center; justify-content: center;
    font-size: 30px;
}
.video-placeholder p { font-size: 14px; line-height: 1.5; max-width: 320px; }
.video-caption {
    padding: 14px 20px; font-size: 12px; color: var(--muted);
    font-weight: 500; border-top: 1px solid var(--border);
    display: flex; align-items: center; gap: 8px;
}

/* Lesson body */
.lesson-body {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px; padding: 32px;
    margin-bottom: 24px;
    font-size: 15px; line-height: 1.8; color: var(--text-soft);
}
.lesson-body h2, .lesson-body h3 {
    font-family: var(--font-serif); font-weight: 400;
    color: var(--text); letter-spacing: -0.01em; margin-bottom: 12px; margin-top: 28px;
}
.lesson-body h2 { font-size: 24px; }
.lesson-body h3 { font-size: 20px; }
.lesson-body p { margin-bottom: 16px; }
.lesson-body strong { color: var(--text); font-weight: 600; }
.lesson-body em { color: var(--purple); font-style: italic; }
.lesson-body ul, .lesson-body ol {
    padding-left: 20px; margin-bottom: 16px; display: flex; flex-direction: column; gap: 6px;
}
.lesson-body li { color: var(--text-soft); }
.lesson-body code {
    background: var(--lav-1); color: var(--purple-dark);
    padding: 2px 8px; border-radius: 6px; font-size: 13px;
    font-family: 'Courier New', monospace;
}
.lesson-body pre {
    background: var(--navy); color: #E8F0FE;
    padding: 20px 24px; border-radius: 14px; overflow-x: auto;
    margin-bottom: 16px; font-size: 13px; line-height: 1.7;
}
.lesson-body pre code { background: none; color: inherit; padding: 0; }
.lesson-body blockquote {
    margin: 20px 0; padding: 18px 20px 18px 52px;
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border-left: 4px solid var(--purple); border-radius: 14px;
    font-family: var(--font-serif); font-size: 17px; font-style: italic;
    color: var(--text); line-height: 1.6; position: relative;
}
.lesson-body blockquote::before {
    content: '"'; font-size: 60px; color: var(--purple);
    position: absolute; top: 8px; left: 14px; opacity: 0.2;
    font-style: normal; line-height: 1;
}

/* No content placeholder */
.no-content-box {
    background: linear-gradient(135deg, var(--lav-1), rgba(255,255,255,0.5));
    border: 1px dashed var(--lav-3); border-radius: 20px;
    padding: 48px 32px; text-align: center; margin-bottom: 24px;
}
.no-content-icon { font-size: 48px; margin-bottom: 14px; }
.no-content-title {
    font-family: var(--font-serif); font-size: 22px; font-weight: 400;
    margin-bottom: 8px; color: var(--text);
}
.no-content-desc { font-size: 13px; color: var(--muted); line-height: 1.6; }

/* Mark complete + navigation */
.lesson-actions {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 20px; padding: 24px;
    display: flex; justify-content: space-between; align-items: center;
    gap: 16px; flex-wrap: wrap; margin-bottom: 32px;
}
.complete-block { display: flex; align-items: center; gap: 12px; }
.btn-complete {
    display: flex; align-items: center; gap: 8px;
    padding: 11px 22px;
    background: linear-gradient(135deg, var(--teal), #00A075);
    color: white; border: none; border-radius: 100px;
    font-family: var(--font-sans); font-size: 13px; font-weight: 700;
    cursor: pointer; transition: all 0.25s;
    box-shadow: 0 4px 14px rgba(0,200,150,0.3);
}
.btn-complete:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,200,150,0.4); }
.btn-complete.done {
    background: linear-gradient(135deg, #00A075, var(--teal));
    box-shadow: none;
}
.complete-label { font-size: 12px; color: var(--muted); font-weight: 500; }

.lesson-nav { display: flex; gap: 10px; }
.btn-lesson-nav {
    display: flex; align-items: center; gap: 8px;
    padding: 11px 20px;
    background: rgba(255,255,255,0.7); border: 1.5px solid var(--border);
    border-radius: 100px; text-decoration: none;
    font-size: 13px; font-weight: 600; color: var(--text-soft);
    transition: all 0.2s; white-space: nowrap;
}
.btn-lesson-nav:hover { background: white; border-color: var(--purple); color: var(--purple); }
.btn-lesson-nav.primary {
    background: #1A1825; border-color: #1A1825; color: white;
}
.btn-lesson-nav.primary:hover { background: #2A2840; border-color: #2A2840; }
.btn-lesson-nav.disabled {
    opacity: 0.4; pointer-events: none;
}

/* ═══ FOOTER ═══ */
.learn-footer {
    padding: 20px 40px;
    border-top: 1px solid var(--border);
    display: flex; justify-content: space-between; align-items: center;
    flex-wrap: wrap; gap: 12px;
}
.footer-logo {
    display: flex; align-items: center; gap: 8px;
    text-decoration: none; color: var(--text);
}
.footer-logo img { width: 28px; height: 28px; border-radius: 7px; object-fit: cover; }
.footer-logo span { font-size: 14px; font-weight: 700; letter-spacing: -0.02em; }
.footer-links { display: flex; gap: 20px; flex-wrap: wrap; }
.footer-links a {
    font-size: 11px; color: var(--muted); text-decoration: none;
    font-weight: 500; transition: color 0.2s;
}
.footer-links a:hover { color: var(--purple); }
.footer-copy { font-size: 11px; color: var(--muted); font-weight: 500; }

/* ═══ SIDEBAR TOGGLE MOBILE ═══ */
.sidebar-toggle {
    display: none; position: fixed;
    bottom: 24px; right: 24px; z-index: 300;
    width: 52px; height: 52px; border-radius: 50%;
    background: #1A1825; color: white; border: none;
    font-size: 20px; cursor: pointer;
    box-shadow: 0 8px 24px rgba(26,24,37,0.3);
    align-items: center; justify-content: center;
    transition: all 0.2s;
}
.sidebar-toggle:hover { background: #2A2840; transform: scale(1.05); }

/* ═══ RESPONSIVE ═══ */
@media (max-width: 960px) {
    :root { --sidebar-w: 280px; }
}
@media (max-width: 768px) {
    .learn-sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
        z-index: 150;
    }
    .learn-sidebar.open { transform: translateX(0); }
    .learn-main { margin-left: 0; }
    .learn-content { padding: 20px; }
    .sidebar-toggle { display: flex; }
    .navbar-progress-wrap { display: none; }
    .lesson-actions { flex-direction: column; align-items: stretch; }
    .lesson-nav { justify-content: center; }
    .learn-footer { flex-direction: column; align-items: flex-start; }
}
@media (max-width: 480px) {
    .learn-content { padding: 16px; }
    .lesson-body { padding: 20px; }
    .btn-nav-outline { display: none; }
}
</style>
</head>
<body>

{{-- ════════ NAVBAR ════════ --}}
<nav class="navbar-wrap" id="mainNavbar">
    <div class="navbar-inner">
        <a href="{{ route('home') }}" class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="Coursify" class="logo-img">
            <span class="logo-text">Coursify</span>
        </a>

        <div class="navbar-divider"></div>

        <span class="navbar-course-title">{{ $course->title }}</span>

        @php
            $totalLessons   = $sections->flatMap->lessons->count();
            $completedCount = $progress->where('is_completed', true)->count();
            $progressPct    = $totalLessons > 0 ? round($completedCount / $totalLessons * 100) : 0;
        @endphp

        <div class="navbar-progress-wrap">
            <div class="navbar-progress-bar">
                <div class="navbar-progress-fill" id="navProgressFill"
                     style="width: {{ $progressPct }}%"></div>
            </div>
            <span class="navbar-progress-pct" id="navProgressPct">{{ $progressPct }}%</span>
        </div>

        <a href="{{ route('courses.show', $course->slug) }}" class="btn-nav-outline">Course Detail</a>
        <a href="{{ route('student.index') }}" class="btn-nav-dark">Dashboard</a>
    </div>
</nav>

{{-- ════════ LAYOUT ════════ --}}
<div class="learn-layout">

    {{-- ════════ SIDEBAR ════════ --}}
    <aside class="learn-sidebar" id="learnSidebar">
        <div class="sidebar-header">
            <div class="sidebar-course-label">Course Content</div>
            <div class="sidebar-course-title">{{ $course->title }}</div>
            <div class="sidebar-progress-block">
                <div class="sidebar-progress-label">
                    <span>Progress</span>
                    <span id="sidebarProgressPct">{{ $progressPct }}%</span>
                </div>
                <div class="sidebar-progress-bar">
                    <div class="sidebar-progress-fill" id="sidebarProgressFill"
                         style="width: {{ $progressPct }}%"></div>
                </div>
            </div>
        </div>

        <div class="sidebar-sections">
            @php $lessonCounter = 0; @endphp
            @foreach($sections as $sIdx => $section)
                @php
                    $sectionLessons  = $section->lessons;
                    $isActiveSection = $sectionLessons->contains('id', $lesson->id);
                @endphp
                <div class="sidebar-section {{ $isActiveSection ? 'open' : '' }}"
                     id="sidebarSection{{ $section->id }}">
                    <button class="sidebar-section-header"
                            onclick="toggleSidebarSection({{ $section->id }})" type="button">
                        <div class="sidebar-section-icon">{{ $sIdx + 1 }}</div>
                        <span class="sidebar-section-name">{{ $section->title }}</span>
                        <span class="sidebar-section-count">{{ $sectionLessons->count() }}</span>
                        <span class="sidebar-section-chevron">▾</span>
                    </button>

                    <div class="sidebar-lessons" id="sidebarLessons{{ $section->id }}">
                        @foreach($sectionLessons as $lIdx => $sLesson)
                            @php
                                $lessonCounter++;
                                $isActive    = $sLesson->id === $lesson->id;
                                $isCompleted = isset($progress[$sLesson->id]) && $progress[$sLesson->id]->is_completed;
                            @endphp
                            <a href="{{ route('student.learn.lesson', [$course->slug, $sLesson->id]) }}"
                               class="sidebar-lesson {{ $isActive ? 'active' : ($isCompleted ? 'completed' : '') }}">
                                <div class="lesson-check">
                                    @if($isCompleted) ✓
                                    @elseif($isActive) ▶
                                    @endif
                                </div>
                                <span class="lesson-num">{{ $lessonCounter }}</span>
                                <span class="lesson-label">{{ $sLesson->title }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </aside>

    {{-- ════════ MAIN ════════ --}}
    <main class="learn-main">
        <div class="learn-content">

            {{-- Breadcrumb --}}
            <div class="learn-breadcrumb">
                <a href="{{ route('student.index') }}">Dashboard</a>
                <span class="learn-breadcrumb-sep">/</span>
                <a href="{{ route('courses.show', $course->slug) }}">{{ Str::limit($course->title, 40) }}</a>
                <span class="learn-breadcrumb-sep">/</span>
                <span class="learn-breadcrumb-current">{{ Str::limit($lesson->title, 50) }}</span>
            </div>

            {{-- Upgrade Banner --}}
            @if(isset($isAudit) && $isAudit && isset($isAuditExpired))
                <div style="background: {{ $isAuditExpired ? 'var(--orange-light)' : 'var(--lav-1)' }}; border: 1px solid {{ $isAuditExpired ? 'var(--orange)' : 'var(--purple)' }}; border-radius: 12px; padding: 16px 20px; margin-bottom: 24px; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:16px;">
                    <div>
                        <div style="font-weight: 700; color: var(--text); margin-bottom: 4px; display:flex; align-items:center; gap:8px;">
                            @if($isAuditExpired)
                                Akses Audit Berakhir
                            @else
                                Anda dalam mode Audit
                            @endif
                        </div>
                        <div style="font-size: 13px; color: var(--text-soft);">
                            @if($isAuditExpired)
                                Akses gratis Anda ke kursus ini telah berakhir. Upgrade ke Verified Track untuk mengembalikan akses selamanya dan mendapatkan sertifikat.
                            @else
                                Upgrade ke Verified Track untuk mendapatkan sertifikat kelulusan resmi, akses selamanya, dan tugas bernilai.
                            @endif
                        </div>
                    </div>
                    @if($course->hasCertificatePrice() && $course->isUpgradeAvailable())
                        <a href="{{ route('payment.index', ['course' => $course->id, 'track' => 'verified', 'upgrade' => 1]) }}" class="btn-nav-dark" style="background:var(--purple); border:none; padding:10px 20px; color:white; text-decoration:none; border-radius:100px;">
                            Upgrade ke Verified ({{ $course->formatted_certificate_price }})
                        </a>
                    @endif
                </div>
            @endif

            {{-- Lesson Header --}}
            <div class="lesson-header">
                <div class="lesson-section-badge">
                    📚 {{ $sections->first(fn($s) => $s->lessons->contains('id', $lesson->id))?->title ?? 'Lesson' }}
                </div>
                <h1 class="lesson-title">{{ $lesson->title }}</h1>
                <div class="lesson-meta">
                    <span class="lesson-meta-item">📖 Lesson {{ $sections->flatMap->lessons->search(fn($l) => $l->id === $lesson->id) + 1 }} of {{ $totalLessons }}</span>
                    @if($lesson->duration_minutes ?? false)
                        <span class="lesson-meta-item">🕐 {{ $lesson->duration_minutes }} min</span>
                    @endif
                    @if(isset($progress[$lesson->id]) && $progress[$lesson->id]->is_completed)
                        <span class="lesson-meta-item" style="color:var(--teal);">✓ Completed</span>
                    @endif
                </div>
            </div>

            @if(isset($isAuditExpired) && $isAuditExpired)
                <div class="no-content-box" style="background: #fff; border: 1px solid var(--border); padding: 40px 20px;">
                    <div class="no-content-icon" style="color: var(--orange); background: var(--orange-light);"><i class="fa-solid fa-lock"></i></div>
                    <div class="no-content-title">Konten Terkunci</div>
                    <p class="no-content-desc">Waktu akses audit Anda untuk materi ini telah berakhir. Silakan upgrade ke Verified Track untuk membuka kembali materi ini.</p>
                </div>
            @else
                {{-- Video / YouTube Embed --}}
                @php
                    $videoUrl   = $lesson->video_url ?? null;
                    $youtubeId  = null;
                    if ($videoUrl) {
                        preg_match('/(?:youtube\.com\/(?:watch\?v=|embed\/)|youtu\.be\/)([a-zA-Z0-9_-]{11})/', $videoUrl, $m);
                        $youtubeId = $m[1] ?? null;
                    }
                @endphp

                @if($youtubeId)
                    <div class="video-wrap">
                        <div class="video-frame">
                            <iframe
                                src="https://www.youtube.com/embed/{{ $youtubeId }}?rel=0&modestbranding=1"
                                title="{{ $lesson->title }}"
                                allowfullscreen
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                            </iframe>
                        </div>
                        <div class="video-caption">
                            🎬 <span>{{ $lesson->title }}</span>
                        </div>
                    </div>
                @elseif($videoUrl)
                    <div class="video-wrap">
                        <div class="video-frame">
                            <video controls style="position:absolute;inset:0;width:100%;height:100%;background:#000;">
                                <source src="{{ $videoUrl }}">
                            </video>
                        </div>
                        <div class="video-caption">🎬 <span>{{ $lesson->title }}</span></div>
                    </div>
                @endif

                {{-- Lesson Content --}}
                @if($lesson->content ?? false)
                    <div class="lesson-body">
                        {!! $lesson->content !!}
                    </div>
                @elseif(!$youtubeId && !$videoUrl)
                    <div class="no-content-box">
                        <div class="no-content-icon">📝</div>
                        <div class="no-content-title">Materi akan segera tersedia</div>
                        <p class="no-content-desc">Instruktur sedang menyiapkan konten untuk lesson ini. Silakan cek kembali nanti.</p>
                    </div>
                @endif
            @endif

            {{-- Actions: Mark Complete + Navigation --}}
            @php
                $allLessons  = $sections->flatMap->lessons->values();
                $currentIdx  = $allLessons->search(fn($l) => $l->id === $lesson->id);
                $prevLesson  = $currentIdx > 0 ? $allLessons[$currentIdx - 1] : null;
                $nextLesson  = $currentIdx < $allLessons->count() - 1 ? $allLessons[$currentIdx + 1] : null;
                $isCompleted = isset($progress[$lesson->id]) && $progress[$lesson->id]->is_completed;
            @endphp

            @if(!isset($isAuditExpired) || !$isAuditExpired)
            <div class="lesson-actions">
                <div class="complete-block">
                    <button class="btn-complete {{ $isCompleted ? 'done' : '' }}"
                            id="btnComplete"
                            onclick="markComplete({{ $lesson->id }}, {{ $isCompleted ? 'true' : 'false' }})">
                        <span id="btnCompleteIcon">{{ $isCompleted ? '✓' : '○' }}</span>
                        <span id="btnCompleteText">{{ $isCompleted ? 'Completed' : 'Mark as Complete' }}</span>
                    </button>
                    <span class="complete-label">{{ $completedCount }}/{{ $totalLessons }} lessons done</span>
                </div>

                <div class="lesson-nav">
                    @if($prevLesson)
                        <a href="{{ route('student.learn.lesson', [$course->slug, $prevLesson->id]) }}"
                           class="btn-lesson-nav">
                            ← Prev
                        </a>
                    @else
                        <span class="btn-lesson-nav disabled">← Prev</span>
                    @endif

                    @if($nextLesson)
                        <a href="{{ route('student.learn.lesson', [$course->slug, $nextLesson->id]) }}"
                           class="btn-lesson-nav primary">
                            Next →
                        </a>
                    @else
                        <a href="{{ route('student.index') }}" class="btn-lesson-nav primary">
                            🎓 Finish Course
                        </a>
                    @endif
                </div>
            </div>
            @endif

        </div>{{-- end .learn-content --}}

        {{-- Footer --}}
        <footer class="learn-footer">
            <a href="{{ route('home') }}" class="footer-logo">
                <img src="{{ asset('images/logo.png') }}" alt="Coursify">
                <span>Coursify</span>
            </a>
            <div class="footer-links">
                <a href="{{ route('about') }}">About</a>
                <a href="{{ route('terms') }}">Terms</a>
                <a href="{{ route('privacy') }}">Privacy</a>
                <a href="{{ route('contact') }}">Contact</a>
            </div>
            <div class="footer-copy">© {{ date('Y') }} Coursify · Supporting SDG 4 🌍</div>
        </footer>

    </main>
</div>

{{-- Mobile sidebar toggle --}}
<button class="sidebar-toggle" id="sidebarToggle" onclick="toggleMobileSidebar()" title="Toggle lessons">
    ☰
</button>

<script>
// ── Sidebar section toggle ─────────────────────────────
function toggleSidebarSection(id) {
    const section  = document.getElementById('sidebarSection' + id);
    section.classList.toggle('open');
}

// ── Mobile sidebar ─────────────────────────────────────
function toggleMobileSidebar() {
    const sidebar = document.getElementById('learnSidebar');
    const toggle  = document.getElementById('sidebarToggle');
    sidebar.classList.toggle('open');
    toggle.textContent = sidebar.classList.contains('open') ? '✕' : '☰';
}

// Close sidebar on outside click (mobile)
document.addEventListener('click', function(e) {
    const sidebar = document.getElementById('learnSidebar');
    const toggle  = document.getElementById('sidebarToggle');
    if (window.innerWidth <= 768
        && sidebar.classList.contains('open')
        && !sidebar.contains(e.target)
        && e.target !== toggle) {
        sidebar.classList.remove('open');
        toggle.textContent = '☰';
    }
});

// ── Mark complete ──────────────────────────────────────
function markComplete(lessonId, currentlyDone) {
    const btn      = document.getElementById('btnComplete');
    const icon     = document.getElementById('btnCompleteIcon');
    const text     = document.getElementById('btnCompleteText');
    const newState = !currentlyDone;

    btn.disabled = true;

    fetch(`/dashboard/progress/${lessonId}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({ is_completed: newState }),
    })
    .then(res => res.json())
    .then(data => {
        btn.disabled = false;

        if (newState) {
            btn.classList.add('done');
            icon.textContent = '✓';
            text.textContent = 'Completed';
            // Update sidebar lesson style
            const sidebarLesson = document.querySelector(`.sidebar-lesson.active`);
            if (sidebarLesson) sidebarLesson.classList.add('completed');
        } else {
            btn.classList.remove('done');
            icon.textContent = '○';
            text.textContent = 'Mark as Complete';
        }

        // Update progress bars
        if (data.progress !== undefined) {
            const pct = Math.round(data.progress);
            const pctStr = pct + '%';
            document.getElementById('navProgressFill').style.width  = pctStr;
            document.getElementById('navProgressPct').textContent   = pctStr;
            document.getElementById('sidebarProgressFill').style.width = pctStr;
            document.getElementById('sidebarProgressPct').textContent  = pctStr;
        }

        // Re-set onclick for next toggle
        btn.setAttribute('onclick', `markComplete(${lessonId}, ${newState})`);
    })
    .catch(() => { btn.disabled = false; });
}
</script>

</body>
</html>
