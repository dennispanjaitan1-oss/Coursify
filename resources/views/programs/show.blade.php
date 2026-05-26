@extends('layouts.app')

@section('title', $program->title . ' — Coursify Programs')
@section('meta_description', Str::limit($program->description, 155))

@push('styles')
<style>
/* ═══ PROGRAM HERO ═══ */
.prog-hero {
    padding: 52px 20px 0;
    position: relative;
}
.prog-hero-inner {
    max-width: 1160px;
    margin: 0 auto;
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 48px;
    align-items: start;
}
.prog-breadcrumb {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 12.5px;
    color: var(--muted);
    margin-bottom: 20px;
    flex-wrap: wrap;
}
.prog-breadcrumb a { color: var(--muted); text-decoration: none; }
.prog-breadcrumb a:hover { color: var(--purple); }
.prog-breadcrumb-sep { opacity: 0.4; }

.prog-type-badge {
    display: inline-block;
    padding: 5px 14px;
    border-radius: 100px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 0.06em;
    text-transform: uppercase;
    margin-bottom: 16px;
}
.ptype-professional_certificate { background: rgba(30,58,95,0.1); color: var(--navy); }
.ptype-micromasters               { background: rgba(123,111,232,0.12); color: var(--purple-dark); }
.ptype-xseries                    { background: rgba(0,200,150,0.12); color: #006B52; }
.ptype-specialization             { background: rgba(255,138,91,0.12); color: #B04A00; }

.prog-title {
    font-family: var(--font-serif);
    font-size: clamp(28px, 5vw, 52px);
    font-weight: 400;
    line-height: 1.15;
    letter-spacing: -0.02em;
    color: var(--text);
    margin-bottom: 16px;
}
.prog-description {
    font-size: 16px;
    line-height: 1.65;
    color: var(--text-soft);
    margin-bottom: 24px;
    max-width: 600px;
}
.prog-meta-row {
    display: flex;
    align-items: center;
    gap: 20px;
    flex-wrap: wrap;
    margin-bottom: 28px;
}
.prog-meta-item {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 13px;
    color: var(--text-soft);
    font-weight: 500;
}
.prog-institution-chip {
    display: flex;
    align-items: center;
    gap: 8px;
    background: rgba(255,255,255,0.75);
    border: 1px solid rgba(255,255,255,0.9);
    padding: 6px 14px 6px 8px;
    border-radius: 100px;
    font-size: 13px;
    font-weight: 600;
    color: var(--text);
    text-decoration: none;
    transition: all 0.2s;
}
.prog-institution-chip:hover { background: rgba(255,255,255,0.95); }
.prog-inst-logo {
    width: 24px;
    height: 24px;
    border-radius: 6px;
    object-fit: cover;
    background: linear-gradient(135deg, var(--navy), #2D4D7A);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 10px;
    flex-shrink: 0;
}

/* ═══ SIDEBAR CARD ═══ */
.prog-sidebar-card {
    background: rgba(255,255,255,0.85);
    backdrop-filter: blur(24px);
    border: 1px solid rgba(255,255,255,0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 16px 48px rgba(30,58,95,0.12);
    position: sticky;
    top: 100px;
}
.prog-thumb {
    width: 100%;
    height: 200px;
    object-fit: cover;
    background: linear-gradient(135deg, #EDE5F9, #C4B8E8);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 56px;
}
.prog-sidebar-body { padding: 24px; }
.prog-price-block { margin-bottom: 20px; }
.prog-price-label { font-size: 12px; color: var(--muted); margin-bottom: 4px; }
.prog-price-value {
    font-family: var(--font-serif);
    font-size: 32px;
    color: var(--navy);
    line-height: 1;
}
.prog-price-value.free { color: var(--teal); }
.prog-enroll-btn {
    display: block;
    width: 100%;
    padding: 14px 20px;
    background: var(--navy);
    color: white;
    border: none;
    border-radius: 14px;
    font-family: var(--font-sans);
    font-size: 15px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s;
    margin-bottom: 12px;
}
.prog-enroll-btn:hover {
    background: #2D4D7A;
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(30,58,95,0.2);
}
.prog-audit-btn {
    display: block;
    width: 100%;
    padding: 12px 20px;
    background: rgba(123,111,232,0.08);
    color: var(--purple-dark);
    border: 1.5px solid rgba(123,111,232,0.2);
    border-radius: 14px;
    font-family: var(--font-sans);
    font-size: 14px;
    font-weight: 600;
    text-align: center;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.2s;
    margin-bottom: 20px;
}
.prog-audit-btn:hover {
    background: rgba(123,111,232,0.14);
    border-color: rgba(123,111,232,0.35);
}
.prog-includes {
    display: flex;
    flex-direction: column;
    gap: 10px;
    padding-top: 18px;
    border-top: 1px solid rgba(30,58,95,0.07);
}
.prog-include-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 13px;
    color: var(--text-soft);
}
.prog-include-icon {
    width: 28px;
    height: 28px;
    border-radius: 8px;
    background: rgba(123,111,232,0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
}

/* ═══ STATS STRIP ═══ */
.prog-stats-strip {
    background: rgba(255,255,255,0.6);
    backdrop-filter: blur(20px);
    border-top: 1px solid rgba(255,255,255,0.8);
    border-bottom: 1px solid rgba(255,255,255,0.8);
    padding: 24px 20px;
    margin: 32px 0;
}
.prog-stats-inner {
    max-width: 1160px;
    margin: 0 auto;
    display: flex;
    justify-content: space-around;
    flex-wrap: wrap;
    gap: 20px;
}
.prog-stat {
    text-align: center;
}
.prog-stat-num {
    font-family: var(--font-serif);
    font-size: 32px;
    font-weight: 400;
    color: var(--navy);
    line-height: 1;
}
.prog-stat-label { font-size: 13px; color: var(--muted); margin-top: 4px; }

/* ═══ CONTENT SECTION ═══ */
.prog-content {
    max-width: 1160px;
    margin: 0 auto;
    padding: 0 20px;
    display: grid;
    grid-template-columns: 1fr 360px;
    gap: 48px;
    margin-bottom: 60px;
}
.prog-main { }
.prog-section-title {
    font-family: var(--font-serif);
    font-size: 26px;
    font-weight: 400;
    color: var(--text);
    margin-bottom: 20px;
    letter-spacing: -0.01em;
}
.prog-section { margin-bottom: 48px; }

/* What you'll learn */
.learn-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 12px;
}
.learn-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    font-size: 13.5px;
    color: var(--text-soft);
    line-height: 1.5;
}
.learn-check {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(0,200,150,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
}

/* Course list */
.course-list { display: flex; flex-direction: column; gap: 12px; }
.course-list-item {
    display: flex;
    align-items: center;
    gap: 16px;
    background: rgba(255,255,255,0.65);
    backdrop-filter: blur(16px);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 16px 18px;
    text-decoration: none;
    color: inherit;
    transition: all 0.25s;
}
.course-list-item:hover {
    transform: translateX(4px);
    box-shadow: 0 8px 24px rgba(30,58,95,0.09);
    border-color: rgba(123,111,232,0.2);
}
.course-num {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--lav-2), var(--lav-3));
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 14px;
    color: var(--navy);
    flex-shrink: 0;
}
.course-info { flex: 1; min-width: 0; }
.course-info-title {
    font-weight: 600;
    font-size: 14px;
    color: var(--text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.course-info-meta {
    font-size: 12px;
    color: var(--muted);
    margin-top: 3px;
}
.course-arrow {
    color: var(--muted);
    opacity: 0.4;
    flex-shrink: 0;
}

/* Related programs */
.related-grid { display: grid; grid-template-columns: 1fr; gap: 12px; }
.related-card {
    display: flex;
    gap: 14px;
    background: rgba(255,255,255,0.65);
    border: 1px solid rgba(255,255,255,0.9);
    border-radius: 16px;
    padding: 14px 16px;
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
}
.related-card:hover { background: rgba(255,255,255,0.9); transform: translateX(3px); }
.related-thumb {
    width: 56px;
    height: 56px;
    border-radius: 10px;
    object-fit: cover;
    background: linear-gradient(135deg, #EDE5F9, #C4B8E8);
    flex-shrink: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
}
.related-title { font-weight: 600; font-size: 13px; line-height: 1.4; color: var(--text); }
.related-meta { font-size: 12px; color: var(--muted); margin-top: 4px; }

@media (max-width: 900px) {
    .prog-hero-inner, .prog-content { grid-template-columns: 1fr; }
    .prog-sidebar-card { position: static; }
    .learn-grid { grid-template-columns: 1fr; }
}
</style>
@endpush

@section('content')
<div class="prog-hero">
    <div class="prog-hero-inner">

        <!-- ══ LEFT: INFO ══ -->
        <div>
            <!-- Breadcrumb -->
            <div class="prog-breadcrumb">
                <a href="{{ route('home') }}">Home</a>
                <span class="prog-breadcrumb-sep">/</span>
                <a href="{{ route('programs.index') }}">Programs</a>
                @if($program->category)
                    <span class="prog-breadcrumb-sep">/</span>
                    <a href="{{ route('programs.index', ['category' => $program->category->slug]) }}">{{ $program->category->name }}</a>
                @endif
                <span class="prog-breadcrumb-sep">/</span>
                <span>{{ Str::limit($program->title, 40) }}</span>
            </div>

            <!-- Type badge -->
            <span class="prog-type-badge ptype-{{ $program->type }}">
                {{ match($program->type) {
                    'professional_certificate' => 'Professional Certificate',
                    'micromasters'             => 'MicroMasters Program',
                    'xseries'                  => 'XSeries Program',
                    'specialization'           => 'Specialization',
                    default                    => 'Program',
                } }}
            </span>

            <!-- Title -->
            <h1 class="prog-title">{{ $program->title }}</h1>
            <p class="prog-description">{{ $program->description }}</p>

            <!-- Institution + meta -->
            <div class="prog-meta-row">
                @if($program->institution)
                <a href="{{ route('universities.show', $program->institution->slug ?? '#') }}" class="prog-institution-chip">
                    @if($program->institution->logo_url)
                        <img src="{{ $program->institution->logo_url }}" alt="" style="width:24px;height:24px;border-radius:6px;object-fit:cover;">
                    @else
                        <div class="prog-inst-logo">{{ strtoupper(substr($program->institution->name, 0, 1)) }}</div>
                    @endif
                    {{ $program->institution->name }}
                </a>
                @endif

                <span class="prog-meta-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><rect x="1" y="3" width="12" height="10" rx="2" stroke="#8B87A8" stroke-width="1.3"/><path d="M1 6.5h12" stroke="#8B87A8" stroke-width="1.3"/><path d="M4 1v2M10 1v2" stroke="#8B87A8" stroke-width="1.3" stroke-linecap="round"/></svg>
                    {{ $program->duration_months ? $program->duration_months . ' months' : 'Self-paced' }}
                </span>

                <span class="prog-meta-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="7" cy="7" r="6" stroke="#8B87A8" stroke-width="1.3"/><path d="M7 4v3l2 1.5" stroke="#8B87A8" stroke-width="1.3" stroke-linecap="round"/></svg>
                    {{ $program->effort_per_week ? $program->effort_per_week . ' hrs/week' : 'Flexible pace' }}
                </span>

                <span class="prog-meta-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M7 2.5l1.5 3 3.5.5-2.5 2.5.5 3.5L7 10.5l-3 1.5.5-3.5L2 6l3.5-.5L7 2.5z" stroke="#8B87A8" stroke-width="1.3" stroke-linejoin="round"/></svg>
                    {{ $totalCourses }} courses
                </span>

                @if($totalStudents > 0)
                <span class="prog-meta-item">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none"><circle cx="5" cy="4.5" r="2.5" stroke="#8B87A8" stroke-width="1.3"/><path d="M1 12c0-2.2 1.8-4 4-4s4 1.8 4 4" stroke="#8B87A8" stroke-width="1.3" stroke-linecap="round"/><circle cx="10.5" cy="4" r="2" stroke="#8B87A8" stroke-width="1.2"/><path d="M12.5 12c0-1.8-1-3.2-2.5-3.6" stroke="#8B87A8" stroke-width="1.2" stroke-linecap="round"/></svg>
                    {{ number_format($totalStudents) }}+ students
                </span>
                @endif
            </div>
        </div>

        <!-- ══ RIGHT: SIDEBAR ══ -->
        <div class="prog-sidebar-card">
            <!-- Thumbnail -->
            @if($program->thumbnail_url)
                <img src="{{ $program->thumbnail_url }}" alt="{{ $program->title }}" class="prog-thumb">
            @else
                <div class="prog-thumb">🎓</div>
            @endif

            <div class="prog-sidebar-body">
                <!-- Price -->
                <div class="prog-price-block">
                    <div class="prog-price-label">Program fee</div>
                    <div class="prog-price-value {{ ($program->price ?? 0) == 0 ? 'free' : '' }}">
                        {{ ($program->price ?? 0) == 0 ? 'Free' : 'Rp ' . number_format($program->price, 0, ',', '.') }}
                    </div>
                </div>

                <!-- CTA -->
                @if($program->courses->isNotEmpty())
                    <a href="{{ route('courses.show', $program->courses->first()->slug) }}" class="prog-enroll-btn">
                        Start Learning →
                    </a>
                    <a href="{{ route('courses.index', ['program' => $program->id]) }}" class="prog-audit-btn">
                        View All Courses
                    </a>
                @else
                    <span class="prog-enroll-btn" style="opacity:0.5;cursor:default;background:var(--muted);">
                        Coming Soon
                    </span>
                @endif

                <!-- Includes -->
                <div class="prog-includes">
                    <div class="prog-include-item">
                        <div class="prog-include-icon">📚</div>
                        <span>{{ $totalCourses }} courses in sequence</span>
                    </div>
                    <div class="prog-include-item">
                        <div class="prog-include-icon">🏆</div>
                        <span>Professional certificate on completion</span>
                    </div>
                    <div class="prog-include-item">
                        <div class="prog-include-icon">⏱</div>
                        <span>{{ $totalWeeks ? $totalWeeks . ' weeks total' : 'Self-paced learning' }}</span>
                    </div>
                    <div class="prog-include-item">
                        <div class="prog-include-icon">✅</div>
                        <span>Verified certificate available</span>
                    </div>
                    @if(($program->price ?? 0) == 0)
                    <div class="prog-include-item">
                        <div class="prog-include-icon">🎁</div>
                        <span>Audit for free</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ═══ STATS STRIP ═══ -->
<div class="prog-stats-strip">
    <div class="prog-stats-inner">
        <div class="prog-stat">
            <div class="prog-stat-num">{{ $totalCourses }}</div>
            <div class="prog-stat-label">Courses</div>
        </div>
        <div class="prog-stat">
            <div class="prog-stat-num">{{ $totalWeeks ?? '—' }}</div>
            <div class="prog-stat-label">Weeks Total</div>
        </div>
        <div class="prog-stat">
            <div class="prog-stat-num">{{ number_format($totalStudents) }}</div>
            <div class="prog-stat-label">Students</div>
        </div>
        @if($avgRating > 0)
        <div class="prog-stat">
            <div class="prog-stat-num">{{ number_format($avgRating, 1) }}</div>
            <div class="prog-stat-label">Avg Rating</div>
        </div>
        @endif
        <div class="prog-stat">
            <div class="prog-stat-num">100%</div>
            <div class="prog-stat-label">Online</div>
        </div>
    </div>
</div>

<!-- ═══ MAIN CONTENT ═══ -->
<div class="prog-content">
    <div class="prog-main">

        <!-- What You'll Learn -->
        @if(is_array($program->what_you_learn) && count($program->what_you_learn) > 0)
        <div class="prog-section">
            <h2 class="prog-section-title">What you'll learn</h2>
            <div class="learn-grid">
                @foreach($program->what_you_learn as $item)
                <div class="learn-item">
                    <div class="learn-check">
                        <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
                            <path d="M2 5l2.5 2.5L8 3" stroke="#00C896" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <span>{{ $item }}</span>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Prerequisites -->
        @if($program->prerequisites)
        <div class="prog-section">
            <h2 class="prog-section-title">Prerequisites</h2>
            <p style="font-size:14px;color:var(--text-soft);line-height:1.7;">{{ $program->prerequisites }}</p>
        </div>
        @endif

        <!-- Courses in this program -->
        @if($program->courses->isNotEmpty())
        <div class="prog-section">
            <h2 class="prog-section-title">Courses in this program</h2>
            <div class="course-list">
                @foreach($program->courses as $i => $course)
                <a href="{{ route('courses.show', $course->slug) }}" class="course-list-item">
                    <div class="course-num">{{ $i + 1 }}</div>
                    <div class="course-info">
                        <div class="course-info-title">{{ $course->title }}</div>
                        <div class="course-info-meta">
                            {{ $course->difficulty ? ucfirst($course->difficulty) . ' · ' : '' }}
                            {{ $course->duration_weeks ? $course->duration_weeks . ' weeks' : '' }}
                            @if($course->isFree())
                                · <span style="color:var(--teal);font-weight:600;">Free</span>
                            @endif
                        </div>
                    </div>
                    <svg class="course-arrow" width="16" height="16" viewBox="0 0 16 16" fill="none">
                        <path d="M6 4l4 4-4 4" stroke="#8B87A8" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Career Outcomes -->
        @if($program->career_outcomes)
        <div class="prog-section">
            <h2 class="prog-section-title">Career outcomes</h2>
            <p style="font-size:14px;color:var(--text-soft);line-height:1.7;">{{ $program->career_outcomes }}</p>
        </div>
        @endif

        <!-- FAQ -->
        @if(is_array($program->faq) && count($program->faq) > 0)
        <div class="prog-section">
            <h2 class="prog-section-title">Frequently asked questions</h2>
            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($program->faq as $faqItem)
                <div style="background:rgba(255,255,255,0.65);backdrop-filter:blur(16px);border:1px solid rgba(255,255,255,0.9);border-radius:14px;padding:18px 20px;"
                     x-data="{open:false}">
                    <button @click="open=!open"
                            style="display:flex;justify-content:space-between;align-items:center;width:100%;background:none;border:none;cursor:pointer;text-align:left;font-family:var(--font-sans);font-size:14px;font-weight:600;color:var(--text);padding:0;">
                        {{ $faqItem['question'] ?? '' }}
                        <svg :style="open ? 'transform:rotate(180deg)' : ''" style="transition:transform 0.2s;flex-shrink:0;margin-left:12px;" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <path d="M4 6l4 4 4-4" stroke="#8B87A8" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </button>
                    <div x-show="open" x-transition style="margin-top:12px;font-size:13.5px;color:var(--text-soft);line-height:1.7;">
                        {{ $faqItem['answer'] ?? '' }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>

    <!-- ══ SIDEBAR (desktop only) ══ -->
    <div>
        <!-- Related programs -->
        @if($relatedPrograms->isNotEmpty())
        <div style="margin-bottom:28px;">
            <h3 style="font-family:var(--font-serif);font-size:20px;font-weight:400;margin-bottom:16px;color:var(--text);">Related programs</h3>
            <div class="related-grid">
                @foreach($relatedPrograms as $rp)
                <a href="{{ route('programs.show', $rp->slug) }}" class="related-card">
                    @if($rp->thumbnail_url)
                        <img src="{{ $rp->thumbnail_url }}" alt="" class="related-thumb">
                    @else
                        <div class="related-thumb">🎓</div>
                    @endif
                    <div>
                        <div class="related-title">{{ Str::limit($rp->title, 50) }}</div>
                        <div class="related-meta">{{ $rp->institution?->name ?? 'Coursify' }}</div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Back to programs -->
        <a href="{{ route('programs.index') }}"
           style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text-soft);text-decoration:none;transition:color 0.2s;">
            <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                <path d="M9 2L4 7l5 5" stroke="#8B87A8" stroke-width="1.5" stroke-linecap="round"/>
            </svg>
            All Programs
        </a>
    </div>
</div>
@endsection
