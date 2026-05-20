<!doctype html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sertifikat</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f5f7fb;
            padding: 30px;
        }

        .certificate {
            width: 100%;
            max-width: 1100px;
            margin: auto;
            background: white;
            border-radius: 24px;
            overflow: hidden;
            border: 2px solid #e5e7eb;
            position: relative;
        }

        .top-bar {
            height: 18px;
            background: linear-gradient(90deg, #2563eb, #1d4ed8);
        }

        .content {
            padding: 50px 70px;
            position: relative;
        }

        .brand {
            text-align: left;
            margin-bottom: 30px;
        }

        .brand h1 {
            font-size: 34px;
            color: #1e3a8a;
            margin-bottom: 4px;
        }

        .brand p {
            color: #6b7280;
            font-size: 14px;
        }

        .badge {
            position: absolute;
            top: 50px;
            right: 70px;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 10px 18px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: bold;
        }

        .title {
            text-align: center;
            margin-top: 30px;
        }

        .title h2 {
            font-size: 52px;
            color: #111827;
            letter-spacing: 1px;
        }

        .title p {
            margin-top: 10px;
            color: #6b7280;
            font-size: 16px;
        }

        .recipient {
            text-align: center;
            margin: 50px 0 30px;
        }

        .recipient .label {
            color: #6b7280;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .recipient .name {
            font-size: 42px;
            font-weight: bold;
            color: #1e3a8a;
            border-bottom: 2px solid #dbeafe;
            display: inline-block;
            padding-bottom: 10px;
        }

        .description {
            text-align: center;
            color: #374151;
            font-size: 17px;
            line-height: 1.8;
            margin-top: 20px;
            padding: 0 40px;
        }

        .course-box {
            margin: 40px auto;
            width: 80%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            text-align: center;
        }

        .course-label {
            font-size: 14px;
            color: #64748b;
            margin-bottom: 8px;
        }

        .course-name {
            font-size: 30px;
            font-weight: bold;
            color: #0f172a;
        }

        .info-grid {
            display: table;
            width: 100%;
            margin-top: 50px;
        }

        .info-box {
            display: table-cell;
            width: 33.3%;
            text-align: center;
        }

        .info-title {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-value {
            font-size: 16px;
            font-weight: bold;
            color: #111827;
        }

        .signature-area {
            margin-top: 70px;
            display: table;
            width: 100%;
        }

        .signature {
            display: table-cell;
            width: 50%;
            text-align: center;
            vertical-align: bottom;
        }

        .signature-line {
            width: 220px;
            border-top: 1px solid #9ca3af;
            margin: 0 auto 10px;
        }

        .signature-name {
            font-size: 15px;
            font-weight: bold;
            color: #111827;
        }

        .signature-role {
            font-size: 13px;
            color: #6b7280;
        }

        .footer {
            margin-top: 60px;
            text-align: center;
            font-size: 12px;
            color: #94a3b8;
        }

        .watermark {
            position: absolute;
            bottom: 80px;
            right: 50px;
            font-size: 90px;
            color: rgba(37, 99, 235, 0.04);
            font-weight: bold;
            transform: rotate(-20deg);
        }
    </style>
</head>
<body>

<div class="certificate">

    <div class="top-bar"></div>

    <div class="content">

        <div class="watermark">COURSIFY</div>

        <div class="brand">
            <h1>COURSIFY</h1>
            <p>Platform Belajar Online Bersertifikat</p>
        </div>

        <div class="badge">
            ✓ TERVERIFIKASI
        </div>

        <div class="title">
            <h2>Certificate</h2>
            <p>of Completion</p>
        </div>

        <div class="recipient">
            <div class="label">
                Diberikan kepada
            </div>

            <div class="name">
                {{ $user->name ?? ($certificate->recipient_name ?? 'Student') }}
            </div>
        </div>

        <div class="description">
            Telah berhasil menyelesaikan program kursus dengan hasil memuaskan dan dinyatakan lulus pada kelas berikut.
        </div>

        <div class="course-box">
            <div class="course-label">
                COURSE
            </div>

            <div class="course-name">
                {{ $course->title ?? 'Course Title' }}
            </div>
        </div>

        <div class="info-grid">

            <div class="info-box">
                <div class="info-title">Tanggal Terbit</div>
                <div class="info-value">
                    {{ optional($certificate->issued_at)->format('d M Y') ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="info-title">Nomor Sertifikat</div>
                <div class="info-value">
                    {{ $certificate->certificate_number ?? '-' }}
                </div>
            </div>

            <div class="info-box">
                <div class="info-title">Status</div>
                <div class="info-value">
                    Terverifikasi
                </div>
            </div>

        </div>

        <div class="signature-area">

            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-name">Instruktur Kursus</div>
                <div class="signature-role">Course Instructor</div>
            </div>

            <div class="signature">
                <div class="signature-line"></div>
                <div class="signature-name">Direktur Coursify</div>
                <div class="signature-role">Coursify Platform</div>
            </div>

        </div>

        <div class="footer">
            ID: {{ $certificate->certificate_number ?? '-' }}
        </div>

    </div>

</div>

</body>
</html>