<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }

  body {
    width: 297mm;
    height: 210mm;
    font-family: 'DejaVu Sans', 'Arial', sans-serif;
    background: #ffffff;
    overflow: hidden;
  }

  /* ── Background layer ── */
  .bg-border {
    position: absolute;
    top: 8mm; left: 8mm;
    width: calc(297mm - 16mm);
    height: calc(210mm - 16mm);
    border: 3px solid #1a3a6b;
  }

  .bg-border-inner {
    position: absolute;
    top: 11mm; left: 11mm;
    width: calc(297mm - 22mm);
    height: calc(210mm - 22mm);
    border: 1px solid #a8883a;
  }

  /* Corner ornaments */
  .corner {
    position: absolute;
    width: 20mm;
    height: 20mm;
    border-color: #a8883a;
    border-style: solid;
  }
  .corner-tl { top: 14mm; left: 14mm; border-width: 2px 0 0 2px; }
  .corner-tr { top: 14mm; right: 14mm; border-width: 2px 2px 0 0; }
  .corner-bl { bottom: 14mm; left: 14mm; border-width: 0 0 2px 2px; }
  .corner-br { bottom: 14mm; right: 14mm; border-width: 0 2px 2px 0; }

  /* ── Sidebar kiri ── */
  .sidebar {
    position: absolute;
    left: 0; top: 0;
    width: 52mm;
    height: 210mm;
    background: #1a3a6b;
  }

  .sidebar-logo {
    position: absolute;
    top: 20mm;
    left: 0; right: 0;
    text-align: center;
    color: #ffffff;
  }

  .sidebar-logo .logo-text {
    font-size: 22pt;
    font-weight: bold;
    letter-spacing: 2px;
  }

  .sidebar-logo .logo-sub {
    font-size: 7pt;
    letter-spacing: 3px;
    color: #a8c8f0;
    margin-top: 2mm;
    text-transform: uppercase;
  }

  .sidebar-divider {
    position: absolute;
    top: 52mm;
    left: 8mm; right: 8mm;
    height: 1px;
    background: rgba(168, 136, 58, 0.6);
  }

  .sidebar-course-info {
    position: absolute;
    top: 56mm;
    left: 0; right: 0;
    padding: 0 7mm;
    color: #ffffff;
    text-align: center;
  }

  .sidebar-course-info .label {
    font-size: 6pt;
    letter-spacing: 2px;
    color: #a8c8f0;
    text-transform: uppercase;
    margin-bottom: 2mm;
  }

  .sidebar-course-info .value {
    font-size: 8.5pt;
    font-weight: bold;
    line-height: 1.4;
    word-break: break-word;
  }

  .sidebar-qr {
    position: absolute;
    bottom: 18mm;
    left: 0; right: 0;
    text-align: center;
  }

  .sidebar-qr .qr-label {
    font-size: 5.5pt;
    color: #a8c8f0;
    letter-spacing: 1px;
    text-transform: uppercase;
    margin-top: 2mm;
  }

  /* ── Konten utama ── */
  .content {
    position: absolute;
    left: 58mm;
    top: 0;
    width: calc(297mm - 60mm);
    height: 210mm;
    padding: 18mm 20mm 14mm 12mm;
  }

  .cert-label {
    font-size: 8pt;
    letter-spacing: 4px;
    color: #a8883a;
    text-transform: uppercase;
    margin-bottom: 3mm;
  }

  .cert-title {
    font-size: 30pt;
    font-weight: bold;
    color: #1a3a6b;
    line-height: 1.1;
    margin-bottom: 6mm;
    font-style: italic;
  }

  .cert-subtitle {
    font-size: 9pt;
    color: #555;
    letter-spacing: 1px;
    margin-bottom: 8mm;
  }

  /* Nama penerima */
  .recipient-label {
    font-size: 7.5pt;
    color: #888;
    letter-spacing: 2px;
    text-transform: uppercase;
    margin-bottom: 2mm;
  }

  .recipient-name {
    font-size: 26pt;
    font-weight: bold;
    color: #1a3a6b;
    border-bottom: 2px solid #a8883a;
    padding-bottom: 3mm;
    margin-bottom: 6mm;
    line-height: 1.2;
  }

  /* Deskripsi */
  .cert-desc {
    font-size: 9pt;
    color: #444;
    line-height: 1.7;
    margin-bottom: 8mm;
    max-width: 160mm;
  }

  /* Info badges */
  .info-row {
    display: table;
    width: 100%;
    margin-bottom: 10mm;
  }

  .info-cell {
    display: table-cell;
    width: 33%;
    vertical-align: top;
  }

  .info-cell .label {
    font-size: 6.5pt;
    letter-spacing: 1.5px;
    color: #a8883a;
    text-transform: uppercase;
    margin-bottom: 1.5mm;
  }

  .info-cell .value {
    font-size: 9pt;
    font-weight: bold;
    color: #1a3a6b;
  }

  /* Tanda tangan */
  .signatures {
    display: table;
    width: 100%;
    margin-top: 2mm;
  }

  .sig-cell {
    display: table-cell;
    width: 50%;
    text-align: center;
    padding: 0 8mm;
  }

  .sig-line {
    width: 60%;
    margin: 0 auto;
    border-top: 1.5px solid #1a3a6b;
    margin-top: 10mm;
    padding-top: 2mm;
  }

  .sig-name {
    font-size: 8.5pt;
    font-weight: bold;
    color: #1a3a6b;
  }

  .sig-role {
    font-size: 7pt;
    color: #777;
    letter-spacing: 1px;
    margin-top: 0.5mm;
  }

  /* Nomor sertifikat */
  .cert-number {
    position: absolute;
    bottom: 10mm;
    right: 20mm;
    font-size: 7pt;
    color: #aaa;
    letter-spacing: 1px;
  }

  /* Watermark diagonal (subtle) */
  .watermark {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) rotate(-30deg);
    font-size: 80pt;
    font-weight: bold;
    color: rgba(26, 58, 107, 0.04);
    letter-spacing: 10px;
    white-space: nowrap;
    pointer-events: none;
    user-select: none;
  }
</style>
</head>
<body>

{{-- Watermark --}}
<div class="watermark">COURSIFY</div>

{{-- Border ornamen --}}
<div class="bg-border"></div>
<div class="bg-border-inner"></div>
<div class="corner corner-tl"></div>
<div class="corner corner-tr"></div>
<div class="corner corner-bl"></div>
<div class="corner corner-br"></div>

{{-- Sidebar kiri --}}
<div class="sidebar">
  <div class="sidebar-logo">
    <div class="logo-text">Coursify</div>
    <div class="logo-sub">Platform Belajar</div>
  </div>

  <div class="sidebar-divider"></div>

  <div class="sidebar-course-info">
    <div class="label">Institusi</div>
    <div class="value">{{ $course->institution?->name ?? 'Coursify Academy' }}</div>

    <br>
    <div class="label" style="margin-top: 5mm;">Kategori</div>
    <div class="value">{{ $course->category?->name ?? '-' }}</div>

    @if($course->difficulty)
    <br>
    <div class="label" style="margin-top: 5mm;">Level</div>
    <div class="value">{{ ucfirst($course->difficulty) }}</div>
    @endif
  </div>

  <div class="sidebar-qr">
    {{-- QR code sederhana dari text -- dompdf tidak render QR native, gunakan URL text --}}
    <div style="background: white; padding: 3mm; display: inline-block; font-size: 5pt; color: #1a3a6b; word-break: break-all; max-width: 36mm; text-align: center;">
      Verifikasi:<br>
      {{ url('/verify/' . $certificate->certificate_number) }}
    </div>
    <div class="qr-label">Scan untuk verifikasi</div>
  </div>
</div>

{{-- Konten utama --}}
<div class="content">
  <div class="cert-label">Sertifikat Penyelesaian</div>

  <div class="cert-title">Certificate<br>of Completion</div>

  <div class="cert-subtitle">Diberikan kepada yang tersebut di bawah ini</div>

  <div class="recipient-label">Nama Peserta</div>
  <div class="recipient-name">{{ $user->name }}</div>

  <div class="cert-desc">
    Telah berhasil menyelesaikan dan lulus dalam program kursus
    <strong>"{{ $course->title }}"</strong>
    yang diselenggarakan oleh <strong>{{ $course->institution?->name ?? 'Coursify Academy' }}</strong>
    melalui platform Coursify.
    @if($course->duration_weeks)
      Program ini berlangsung selama <strong>{{ $course->duration_weeks }} minggu</strong>.
    @endif
  </div>

  {{-- Info row --}}
  <div class="info-row">
    <div class="info-cell">
      <div class="label">Tanggal Terbit</div>
      <div class="value">{{ $certificate->issued_at_formatted }}</div>
    </div>
    <div class="info-cell">
      <div class="label">Nomor Sertifikat</div>
      <div class="value">{{ $certificate->certificate_number }}</div>
    </div>
    <div class="info-cell">
      <div class="label">Status</div>
      <div class="value" style="color: #2d7a3a;">✓ Terverifikasi</div>
    </div>
  </div>

  {{-- Tanda tangan --}}
  <div class="signatures">
    <div class="sig-cell">
      <div class="sig-line">
        <div class="sig-name">
          @if($course->instructors->isNotEmpty())
            {{ $course->instructors->first()->name }}
          @else
            Tim Instruktur Coursify
          @endif
        </div>
        <div class="sig-role">Instruktur Kursus</div>
      </div>
    </div>
    <div class="sig-cell">
      <div class="sig-line">
        <div class="sig-name">Direktur Coursify</div>
        <div class="sig-role">Platform Coursify</div>
      </div>
    </div>
  </div>
</div>

{{-- Nomor sertifikat di pojok kanan bawah --}}
<div class="cert-number">ID: {{ $certificate->certificate_number }}</div>

</body>
</html>