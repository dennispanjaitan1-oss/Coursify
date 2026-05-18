@extends('layouts.app')

@section('title', 'Sertifikat Saya - Coursify')

@section('content')
<div class="min-h-screen bg-gray-50">
  <div class="max-w-5xl mx-auto px-4 py-10">

    {{-- Header --}}
    <div class="mb-8">
      <h1 class="text-2xl font-bold text-gray-800">🏅 Sertifikat Saya</h1>
      <p class="text-gray-500 mt-1 text-sm">Sertifikat akan otomatis terbit saat kamu menyelesaikan 100% materi kursus.</p>
    </div>

    {{-- Flash messages --}}
    @if(session('success'))
      <div class="mb-6 bg-green-50 border border-green-200 text-green-700 rounded-xl px-5 py-3.5 text-sm flex items-center gap-2">
        <span>✓</span> {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="mb-6 bg-red-50 border border-red-200 text-red-700 rounded-xl px-5 py-3.5 text-sm flex items-center gap-2">
        <span>✕</span> {{ session('error') }}
      </div>
    @endif
    @if(session('info'))
      <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-700 rounded-xl px-5 py-3.5 text-sm flex items-center gap-2">
        <span>ℹ</span> {{ session('info') }}
      </div>
    @endif

    {{-- Kursus selesai tapi belum ada sertifikat --}}
    @if($completedWithoutCert->isNotEmpty())
      <div class="mb-8">
        <h2 class="text-base font-semibold text-amber-700 mb-3 flex items-center gap-2">
          <span>⚠️</span> Kursus selesai, sertifikat belum diterbitkan
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          @foreach($completedWithoutCert as $enrollment)
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex items-start gap-4">
              <div class="text-3xl">📋</div>
              <div class="flex-1 min-w-0">
                <div class="font-semibold text-gray-800 text-sm leading-snug mb-0.5 truncate">
                  {{ $enrollment->course->title }}
                </div>
                <div class="text-xs text-gray-500 mb-3">
                  {{ $enrollment->course->institution?->name ?? 'Coursify Academy' }}
                </div>
                <form action="{{ route('student.certificates.generate', $enrollment->course) }}" method="POST">
                  @csrf
                  <button
                    type="submit"
                    class="text-xs bg-amber-500 hover:bg-amber-600 text-white px-4 py-1.5 rounded-lg font-medium transition"
                    onclick="return confirm('Terbitkan sertifikat untuk kursus ini?')"
                  >
                    Terbitkan Sertifikat
                  </button>
                </form>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    @endif

    {{-- Daftar sertifikat --}}
    @if($certificates->isEmpty())
      <div class="bg-white rounded-2xl shadow-sm border border-gray-100 py-20 text-center">
        <div class="text-6xl mb-4">🎓</div>
        <h3 class="text-lg font-semibold text-gray-700 mb-2">Belum ada sertifikat</h3>
        <p class="text-gray-400 text-sm max-w-xs mx-auto">
          Selesaikan semua materi kursus untuk mendapatkan sertifikat otomatis.
        </p>
        <a href="{{ route('courses.index') }}" class="inline-block mt-5 bg-blue-600 text-white text-sm px-5 py-2.5 rounded-xl hover:bg-blue-700 transition font-medium">
          Jelajahi Kursus
        </a>
      </div>

    @else
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @foreach($certificates as $cert)
          <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">

            {{-- Banner warna --}}
            <div class="h-3 bg-gradient-to-r from-blue-600 to-indigo-500"></div>

            <div class="p-6">
              {{-- Icon + judul kursus --}}
              <div class="flex items-start gap-4 mb-5">
                <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-2xl flex-shrink-0">
                  🏅
                </div>
                <div class="min-w-0">
                  <h3 class="font-bold text-gray-800 text-sm leading-snug line-clamp-2">
                    {{ $cert->course->title }}
                  </h3>
                  <p class="text-xs text-gray-400 mt-0.5">
                    {{ $cert->course->institution?->name ?? 'Coursify Academy' }}
                  </p>
                </div>
              </div>

              {{-- Info --}}
              <div class="grid grid-cols-2 gap-3 mb-5 text-xs">
                <div>
                  <span class="text-gray-400 uppercase tracking-wide">Tanggal Terbit</span>
                  <div class="font-semibold text-gray-700 mt-0.5">{{ $cert->issued_at_formatted }}</div>
                </div>
                <div>
                  <span class="text-gray-400 uppercase tracking-wide">Nomor Sertifikat</span>
                  <div class="font-mono font-semibold text-gray-700 mt-0.5 text-xs">{{ $cert->certificate_number }}</div>
                </div>
              </div>

              {{-- Badge valid --}}
              <div class="flex items-center gap-1.5 mb-5">
                <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 text-xs px-2.5 py-1 rounded-full font-medium">
                  <span>✓</span> Terverifikasi
                </span>
                @if($cert->course->difficulty)
                  <span class="inline-flex items-center bg-gray-100 text-gray-600 text-xs px-2.5 py-1 rounded-full">
                    {{ ucfirst($cert->course->difficulty) }}
                  </span>
                @endif
              </div>

              {{-- Actions --}}
              <div class="flex gap-2">
                <a
                  href="{{ route('student.certificates.download', $cert->certificate_number) }}"
                  class="flex-1 text-center text-xs bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl font-medium transition"
                >
                  ⬇ Download PDF
                </a>
                <a
                  href="{{ route('student.certificates.preview', $cert->certificate_number) }}"
                  target="_blank"
                  class="flex-1 text-center text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl font-medium transition"
                >
                  👁 Preview
                </a>
                <a
                  href="{{ route('certificates.verify', $cert->certificate_number) }}"
                  target="_blank"
                  class="text-xs bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2.5 rounded-xl font-medium transition"
                  title="Halaman verifikasi publik"
                >
                  🔗
                </a>
              </div>
            </div>
          </div>
        @endforeach
      </div>

      {{-- Total --}}
      <div class="mt-6 text-center text-sm text-gray-400">
        Total {{ $certificates->count() }} sertifikat diterima
      </div>
    @endif

  </div>
</div>
@endsection