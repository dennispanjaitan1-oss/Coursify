<!DOCTYPE html>
<html>
<body style="font-family:sans-serif;background:#f5f3ff;padding:40px 20px;">
<div style="max-width:520px;margin:0 auto;background:#fff;border-radius:16px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.08);">

    <div style="background:#6366f1;padding:32px 40px;">
        <h1 style="color:#fff;margin:0;font-size:24px;">Coursify</h1>
    </div>

    <div style="padding:32px 40px;">
        <h2 style="color:#111;margin:0 0 12px;">Halo, {{ $user->name }}! 👋</h2>
        <p style="color:#6b7280;line-height:1.6;margin:0 0 24px;">
            Akun Coursify kamu berhasil dibuat. Selamat datang di platform belajar terbaik!
            Mulai eksplorasi ribuan kursus dari instruktur terbaik dunia.
        </p>
        <a href="{{ route('courses.index') }}"
           style="display:inline-block;background:#6366f1;color:#fff;padding:14px 28px;
                  border-radius:50px;text-decoration:none;font-weight:700;font-size:14px;">
            Jelajahi Kursus →
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