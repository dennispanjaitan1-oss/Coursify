@extends('layouts.instructor')

@section('title', $course->title)

@section('content')

    {{-- BACK LINK --}}
    <a href="{{ route('instructor.courses.index') }}" style="color: var(--muted); text-decoration: none; display: inline-flex; align-items: center; gap: 8px; font-weight: 600; font-size: 13.5px; margin-bottom: 24px; transition: var(--transition-fast);" onmouseover="this.style.color='var(--purple)'" onmouseout="this.style.color='var(--muted)'">
        <i class="fa-solid fa-arrow-left"></i> Back to Courses
    </a>

    {{-- COURSE HEADER CARD --}}
    <div class="card-wrap" style="background: linear-gradient(135deg, var(--navy) 0%, #1E4A7A 100%); color: white; display: flex; align-items: center; gap: 24px; padding: 28px; margin-bottom: 28px; border-radius: var(--radius-lg); position: relative; overflow: hidden;">
        <div style="position: absolute; right: -50px; bottom: -50px; width: 200px; height: 200px; background: radial-gradient(circle, rgba(255, 255, 255, 0.08), transparent 70%); pointer-events: none;"></div>
        
        <div style="width: 80px; height: 80px; border-radius: var(--radius-md); background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(10px); display: flex; align-items: center; justify-content: center; font-size: 32px; color: var(--lav-3); flex-shrink: 0;">
            <i class="fa-solid {{ $course->icon ?? 'fa-book-open' }}"></i>
        </div>
        
        <div style="flex: 1; min-width: 0;">
            <div style="display: flex; align-items: center; gap: 8px; flex-wrap: wrap; margin-bottom: 6px;">
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; background: var(--purple); color: white; padding: 3px 8px; border-radius: var(--radius-pill); letter-spacing: 0.05em;">{{ $course->category->name ?? 'Uncategorized' }}</span>
                <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; background: rgba(255,255,255,0.15); color: white; padding: 3px 8px; border-radius: var(--radius-pill); letter-spacing: 0.05em;">{{ ucfirst($course->difficulty) }}</span>
            </div>
            <h1 style="font-family: var(--font-serif); font-size: 32px; font-weight: 400; line-height: 1.2; margin-bottom: 8px;">{{ $course->title }}</h1>
            <p style="color: rgba(255,255,255,0.75); font-size: 13.5px; max-width: 600px; line-height: 1.5;">{{ $course->short_description }}</p>
        </div>

        <div style="display: flex; flex-direction: column; gap: 10px; flex-shrink: 0; min-width: 140px; text-align: right;">
            <a href="{{ route('instructor.courses.edit', $course->id) }}" class="btn-welcome btn-welcome--primary" style="justify-content: center; font-size: 12.5px;">
                <i class="fa-solid fa-pen-to-square"></i> Edit Details
            </a>
            <a href="{{ route('courses.show', $course->slug) }}" class="btn-welcome btn-welcome--ghost" style="justify-content: center; font-size: 12.5px;" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square"></i> Live Preview
            </a>
        </div>
    </div>

    {{-- STATS SUMMARY GRID --}}
    <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px;">
        <div class="card-wrap" style="padding: 16px 20px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--teal-light); color: var(--teal); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Students</div>
                <div style="font-size: 20px; font-weight: 700; color: var(--text);">{{ number_format($course->enrollments->count()) }}</div>
            </div>
        </div>
        
        <div class="card-wrap" style="padding: 16px 20px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--gold-light); color: var(--gold); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa-solid fa-star"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Average Rating</div>
                <div style="font-size: 20px; font-weight: 700; color: var(--text);">{{ number_format($course->reviews()->avg('rating') ?? 0, 1) }}</div>
            </div>
        </div>

        <div class="card-wrap" style="padding: 16px 20px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--blue-light); color: var(--blue); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Price</div>
                <div style="font-size: 20px; font-weight: 700; color: var(--text);">Rp {{ number_format($course->price, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="card-wrap" style="padding: 16px 20px; display: flex; align-items: center; gap: 14px;">
            <div style="width: 40px; height: 40px; border-radius: var(--radius-sm); background: var(--pink-light); color: var(--pink); display: flex; align-items: center; justify-content: center; font-size: 18px;">
                <i class="fa-solid fa-circle-play"></i>
            </div>
            <div>
                <div style="font-size: 11px; color: var(--muted); font-weight: 600; text-transform: uppercase;">Total Curriculum</div>
                <div style="font-size: 20px; font-weight: 700; color: var(--text);">{{ $course->sections->count() }} Secs / {{ $course->sections->flatMap->lessons->count() }} Lsns</div>
            </div>
        </div>
    </div>

    {{-- CONTENT DIVISION --}}
    <div style="display: grid; grid-template-columns: 1.8fr 1fr; gap: 28px; align-items: start; margin-bottom: 48px;">
        
        {{-- LEFT MAIN PANEL: CURRICULUM SYLLABUS --}}
        <div class="card-wrap" style="display: flex; flex-direction: column; gap: 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid var(--border); padding-bottom: 12px; margin-bottom: 4px;">
                <h2 style="font-size: 16px; font-weight: 700; color: var(--text); display: flex; align-items: center; gap: 8px;">
                    <i class="fa-solid fa-list-ol" style="color: var(--purple);"></i> Syllabus & Curriculum
                </h2>
                <span style="font-size: 11.5px; font-weight: 700; background: var(--lav-1); color: var(--purple); padding: 4px 10px; border-radius: var(--radius-pill);">{{ $course->sections->count() }} Sections</span>
            </div>

            <div style="display: flex; flex-direction: column; gap: 14px;">
                @forelse($course->sections as $section)
                    <div style="border: 1.5px solid var(--border); border-radius: var(--radius-md); overflow: hidden;">
                        {{-- Section Header --}}
                        <div style="background: var(--lav-1); padding: 14px 18px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1.5px solid var(--border);">
                            <div>
                                <span style="font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--purple); letter-spacing: 0.05em; display: block; margin-bottom: 2px;">Section {{ $loop->iteration }}</span>
                                <h3 style="font-size: 14.5px; font-weight: 700; color: var(--text);">{{ $section->title }}</h3>
                            </div>
                            <span style="font-size: 12px; color: var(--muted); font-weight: 600;">{{ $section->lessons->count() }} Lessons</span>
                        </div>
                        
                        {{-- Lessons List --}}
                        <div style="display: flex; flex-direction: column; background: white;">
                            @forelse($section->lessons as $lesson)
                                <div style="padding: 12px 18px; display: flex; align-items: center; justify-content: space-between; border-bottom: 1px solid rgba(0,0,0,0.04); transition: var(--transition-fast);" onmouseover="this.style.background='rgba(123,111,232,0.02)'" onmouseout="this.style.background='white'">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <i class="fa-solid fa-circle-play" style="color: var(--muted); font-size: 14px;"></i>
                                        <div>
                                            <span style="font-size: 13.5px; font-weight: 600; color: var(--text-soft);">{{ $lesson->title }}</span>
                                            @if($lesson->is_preview)
                                                <span style="font-size: 9.5px; font-weight: 700; text-transform: uppercase; background: var(--teal-light); color: var(--teal); padding: 2px 6px; border-radius: var(--radius-pill); margin-left: 6px;">Preview</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 12px; font-size: 12px; color: var(--muted);">
                                        <span><i class="fa-regular fa-clock"></i> {{ $lesson->duration_minutes ?? 10 }}m</span>
                                        @if($lesson->type === 'video')
                                            <span style="background: var(--lav-2); color: var(--purple); width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;" title="Video Lesson"><i class="fa-solid fa-video"></i></span>
                                        @else
                                            <span style="background: var(--orange-light); color: var(--orange); width: 22px; height: 22px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;" title="Document Lesson"><i class="fa-solid fa-file-lines"></i></span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 16px; text-align: center; color: var(--muted); font-size: 13px;">No lessons added to this section yet.</div>
                            @endforelse
                        </div>
                    </div>
                @empty
                    <div class="empty-state" style="text-align: center; padding: 24px;">
                        <i class="fa-regular fa-folder-open" style="font-size: 28px; color: var(--muted); margin-bottom: 12px;"></i>
                        <h4 style="font-weight: 600; font-size: 14.5px; color: var(--text); margin-bottom: 4px;">Syllabus is Empty</h4>
                        <p style="color: var(--muted); font-size: 12.5px;">Click edit details to link and add new curriculum contents.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- RIGHT PANEL: ENROLLED STUDENTS & INSIGHTS --}}
        <div style="display: flex; flex-direction: column; gap: 24px;">
            
            {{-- Course Description Summary --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 14px;">
                <h2 style="font-size: 14.5px; font-weight: 700; color: var(--text); border-bottom: 1.5px solid var(--border); padding-bottom: 10px; margin-bottom: 2px;">
                    <i class="fa-solid fa-circle-info" style="color: var(--orange); margin-right: 6px;"></i> Full Description
                </h2>
                <div style="font-size: 13px; color: var(--text-soft); line-height: 1.6; word-break: break-word;">
                    {!! nl2br(e($course->description ?? 'No description provided.')) !!}
                </div>
            </div>

            {{-- Recent Enrollments --}}
            <div class="card-wrap" style="display: flex; flex-direction: column; gap: 16px;">
                <h2 style="font-size: 14.5px; font-weight: 700; color: var(--text); border-bottom: 1.5px solid var(--border); padding-bottom: 10px; margin-bottom: 2px;">
                    <i class="fa-solid fa-users" style="color: var(--teal); margin-right: 6px;"></i> Recent Enrollees
                </h2>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    @forelse($course->enrollments->take(5) as $enrollment)
                        <div style="display: flex; align-items: center; gap: 10px; border-bottom: 1px solid rgba(0,0,0,0.03); padding-bottom: 8px;">
                            <div style="width: 32px; height: 32px; border-radius: 50%; background: linear-gradient(135deg, var(--navy), #2D4D7A); color: white; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; flex-shrink: 0;">
                                {{ strtoupper(substr($enrollment->user->name ?? 'S', 0, 1)) }}
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 13px; font-weight: 600; color: var(--text); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $enrollment->user->name ?? 'Student' }}</div>
                                <div style="font-size: 11px; color: var(--muted);">{{ $enrollment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    @empty
                        <div style="font-size: 12.5px; color: var(--muted); text-align: center; padding: 12px 0;">No enrollees yet.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
