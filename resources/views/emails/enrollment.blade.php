<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;background:#f5f3ff;padding:40px 20px;">
<div style="max-width:520px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

    <div style="background:#6366f1;padding:32px 40px;">
        <h1 style="color:#fff;margin:0;font-size:24px;">Coursify</h1>
    </div>

    <div style="padding:32px 40px;">
        <h2 style="color:#111;margin:0 0 4px;">Pendaftaran Berhasil! 🎉</h2>
        <p style="color:#6b7280;margin:0 0 24px;">Halo <strong>{{ $user->name }}</strong>, kamu berhasil mendaftar kursus berikut:</p>

        <div style="background:#f5f3ff;border-radius:12px;padding:20px 24px;margin-bottom:24px;">
            @if($course->thumbnail_url)
                <img src="{{ $course->thumbnail_url }}" alt=""
                     style="width:100%;border-radius:8px;margin-bottom:16px;display:block;">
            @endif
            <p style="font-size:11px;font-weight:700;color:#6366f1;letter-spacing:0.08em;margin:0 0 6px;">
                {{ strtoupper($course->category->name ?? 'KURSUS') }}
            </p>
            <h3 style="color:#111;margin:0 0 8px;font-size:17px;">{{ $course->title }}</h3>
            @php $inst = $course->scrapedInstructors->first() ?? $course->instructors->first(); @endphp
            @if($inst)
                <p style="color:#6b7280;font-size:13px;margin:0;">
                    {{ $inst->name }} · {{ $inst->title ?? 'Instructor' }}
                </p>
            @endif
        </div>

        <a href="{{ route('courses.show', $course->slug) }}"
           style="display:inline-block;background:#6366f1;color:#fff;padding:14px 28px;
                  border-radius:50px;text-decoration:none;font-weight:700;font-size:14px;">
            Mulai Belajar →
        </a>
    </div>

    <div style="padding:20px 40px;border-top:1px solid #f3f4f6;">
        <p style="color:#9ca3af;font-size:12px;margin:0;">
            © {{ date('Y') }} Coursify. Semua hak dilindungi.
        </p>
    </div>

</div>
</body>
</html>