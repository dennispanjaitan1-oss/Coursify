<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemberitahuan Kelulusan Program</title>
</head>
<body style="margin:0;padding:0;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;background-color:#fafafa;color:#1a1a1a;">

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#fafafa;padding:60px 20px;">
    <tr>
        <td align="center">
            <table role="presentation" width="540" cellpadding="0" cellspacing="0" style="max-width:540px;width:100%;background-color:#ffffff;border:1px solid #eaeaea;border-radius:12px;overflow:hidden;box-shadow:0 4px 12px rgba(0,0,0,0.02);">
                
                <!-- Header -->
                <tr>
                    <td style="padding:48px 48px 24px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <span style="font-size:20px;font-weight:700;letter-spacing:-0.5px;color:#111111;text-transform:uppercase;">Coursify</span>
                                </td>
                                <td align="right" style="font-size:11px;color:#999999;font-weight:600;letter-spacing:0.8px;text-transform:uppercase;">
                                    Pemberitahuan Kelulusan
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Content -->
                <tr>
                    <td style="padding:0 48px 36px;">
                        <h1 style="margin:0 0 16px;font-size:24px;font-weight:600;color:#111111;letter-spacing:-0.3px;line-height:1.3;">
                            Pernyataan Kelulusan
                        </h1>
                        <p style="margin:0 0 28px;font-size:14px;color:#666666;line-height:1.6;">
                            Dengan hormat,<br><br>
                            Kami mengucapkan selamat kepada {{ $user->name }} atas keberhasilan menyelesaikan seluruh persyaratan akademis dan kurikulum pada program berikut:
                        </p>

                        <!-- Program Card -->
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f9f9f9;border:1px solid #eaeaea;border-radius:8px;margin-bottom:28px;">
                            <tr>
                                <td style="padding:24px;">
                                    <p style="margin:0 0 6px;font-size:10px;font-weight:700;color:#888888;letter-spacing:1px;text-transform:uppercase;">
                                        {{ $course->category->name ?? 'Program' }}
                                    </p>
                                    <h2 style="margin:0 0 12px;font-size:18px;font-weight:600;color:#111111;line-height:1.4;letter-spacing:-0.2px;">
                                        {{ $course->title }}
                                    </h2>
                                    @php $inst = $course->scrapedInstructors->first() ?? $course->instructors->first(); @endphp
                                    @if($inst)
                                        <p style="margin:0 0 16px;font-size:13px;color:#666666;">
                                            Instruktur: {{ $inst->name }}
                                        </p>
                                    @endif

                                    <!-- Ruang Sertifikat -->
                                    @if($certificate)
                                        <div style="border-top:1px solid #eaeaea;padding-top:16px;margin-top:16px;">
                                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="font-size:12px;color:#666666;line-height:1.5;">
                                                        <span style="font-weight:600;color:#111111;display:block;">Sertifikat Resmi Terbit</span>
                                                        Nomor: {{ $certificate->certificate_number }}<br>
                                                        Tanggal Terbit: {{ $certificate->issued_at->format('d M Y') }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    @endif
                                </td>
                            </tr>
                        </table>

                        <!-- CTA -->
                        <table role="presentation" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    @if($certificate)
                                        <a href="{{ route('certificates.verify', $certificate->certificate_number) }}"
                                           style="display:inline-block;background-color:#111111;color:#ffffff;padding:12px 28px;
                                                  border-radius:6px;text-decoration:none;font-weight:500;font-size:13px;letter-spacing:0.5px;">
                                            Verifikasi Sertifikat
                                        </a>
                                    @else
                                        <a href="{{ route('courses.index') }}"
                                           style="display:inline-block;background-color:#111111;color:#ffffff;padding:12px 28px;
                                                  border-radius:6px;text-decoration:none;font-weight:500;font-size:13px;letter-spacing:0.5px;">
                                            Kembali ke Beranda
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <!-- Footer Separator -->
                <tr>
                    <td style="padding:0 48px;">
                        <div style="height:1px;background-color:#eaeaea;"></div>
                    </td>
                </tr>

                <!-- Footer -->
                <tr>
                    <td style="padding:24px 48px 48px;font-size:12px;color:#999999;line-height:1.5;">
                        <p style="margin:0 0 4px;font-weight:600;color:#666666;">Coursify</p>
                        <p style="margin:0;">
                            Surel ini dikirim secara otomatis sebagai bentuk pernyataan kelulusan yang sah.<br>
                            &copy; {{ date('Y') }} Coursify. Hak cipta dilindungi undang-undang.
                        </p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>

</body>
</html>
