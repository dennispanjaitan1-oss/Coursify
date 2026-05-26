<a href="{{ route('courses.show', $course->slug) }}"
   class="course-card"
   style="display:block; text-decoration:none;">

    {{-- THUMBNAIL --}}
    <div class="course-card__thumb" style="position:relative; aspect-ratio:16/9; overflow:hidden; border-radius:12px 12px 0 0; background:#1a1a2e;">

        {{-- Gambar thumbnail --}}
        @if($course->thumbnail_url)
            <img src="{{ $course->thumbnail_url }}"
                 alt="{{ $course->title }}"
                 style="width:100%;height:100%;object-fit:cover;display:block;">
        @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,#1e3a5f,#2d4d7a);display:flex;align-items:center;justify-content:center;">
                <i class="fa-solid fa-graduation-cap" style="font-size:40px;color:rgba(255,255,255,0.3);"></i>
            </div>
        @endif

        {{-- Badge opsional (BESTSELLER / NEW) dihilangkan sesuai permintaan --}}
        {{-- 
        @php
            $studentsCount = $course->enrollments_count ?? 0;
            $badge = null;
            if ($studentsCount > 5000) { $badge = 'BESTSELLER'; }
            elseif ($course->created_at?->gt(now()->subDays(30))) { $badge = 'NEW'; }
        @endphp
        @if($badge)
            <span style="position:absolute;top:10px;left:10px;background:#f59e0b;color:#fff;font-size:10px;font-weight:800;letter-spacing:0.08em;text-transform:uppercase;padding:3px 8px;border-radius:4px;z-index:2;">
                {{ $badge }}
            </span>
        @endif 
        --}}

        {{-- Wishlist Button --}}
        @auth
            @php
                $isWishlisted = auth()->check() && auth()->user()
                    ->wishlists()->where('course_id', $course->id)->exists();
            @endphp
            <button class="course-wishlist {{ $isWishlisted ? 'active' : '' }}"
                onclick="event.preventDefault(); event.stopPropagation(); toggleWishlist(this, {{ $course->id }});"
                title="{{ $isWishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}"
                aria-label="{{ $isWishlisted ? 'Hapus dari wishlist' : 'Simpan ke wishlist' }}"
                style="position:absolute; top:10px; right:10px; width:34px; height:34px; border-radius:50%; background:rgba(255,255,255,0.9); border:none; display:flex; align-items:center; justify-content:center; cursor:pointer; font-size:15px; z-index:2; transition:all 0.2s; color: {{ $isWishlisted ? 'white' : 'var(--text)' }}; {{ $isWishlisted ? 'background:#FF6B8A;' : '' }}">
                <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
            </button>
        @endauth

        {{-- Logo institusi overlay di pojok kiri bawah --}}
        @php
            $logoUrl = $course->institution->logo_url
                ?? $course->scrapedInstructors->first()?->institution_logo_url
                ?? null;
        @endphp
        @if($logoUrl)
            <div style="position:absolute;bottom:10px;left:10px;background:white;border-radius:6px;padding:4px 8px;max-width:100px;max-height:40px;display:flex;align-items:center;justify-content:center;box-shadow:0 2px 8px rgba(0,0,0,0.25);z-index:2;">
                <img src="{{ $logoUrl }}"
                     alt="{{ $course->institution->name ?? '' }}"
                     style="max-width:88px;max-height:32px;object-fit:contain;display:block;"
                     onerror="this.closest('div').style.display='none';">
            </div>
        @endif
    </div>

    {{-- BODY --}}
    <div class="course-card__body" style="padding:14px 16px 16px;">

        {{-- Category --}}
        @if($course->category)
            <p style="font-size:10px;font-weight:700;letter-spacing:0.09em;text-transform:uppercase;color:var(--purple, #6366f1);margin:0 0 6px;">
                {{ $course->category->name }}
            </p>
        @endif

        {{-- Judul --}}
        <h3 style="font-size:15px;font-weight:700;line-height:1.4;margin:0 0 6px;color:var(--text);
                   display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;">
            {{ $course->title }}
        </h3>

        {{-- Instructor --}}
        @php
            $instructor = $course->scrapedInstructors->first() ?? $course->instructors->first();
        @endphp
        @if($instructor)
            <p style="font-size:12px;color:var(--muted);margin:0 0 10px;
                      white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                {{ $instructor->name }}
                @if($instructor->title ?? false)
                    · <span>{{ $instructor->title }}</span>
                @endif
            </p>
        @endif

        {{-- Meta row --}}
        <div style="display:flex;align-items:center;gap:10px;font-size:12px;color:var(--muted);flex-wrap:wrap;">
            @if($course->reviews_avg_rating ?? false)
                <span>
                    <i class="fa-solid fa-star" style="color:#f59e0b;font-size:11px;"></i>
                    {{ number_format($course->reviews_avg_rating, 1) }}
                </span>
            @endif
            @if(($course->enrollments_count ?? 0) > 0)
                <span>
                    <i class="fa-solid fa-users" style="font-size:11px;"></i>
                    {{ $course->enrollments_count >= 1000 ? number_format($course->enrollments_count / 1000, 1).'k' : $course->enrollments_count }}
                </span>
            @endif
            @if($course->duration_weeks)
                <span>
                    <i class="fa-regular fa-clock" style="font-size:11px;"></i>
                    {{ $course->duration_weeks }}w
                </span>
            @endif
            @if($course->difficulty)
                <span style="text-transform:capitalize;">{{ $course->difficulty }}</span>
            @endif
        </div>

    </div>
</a>
