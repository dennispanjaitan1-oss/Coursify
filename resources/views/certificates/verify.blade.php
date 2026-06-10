@extends('layouts.app')

@section('title', 'Certificate Verification - Coursify')

@section('content')
<div class="min-h-screen bg-gray-50 flex items-center justify-center py-12 px-4">
  <div class="max-w-2xl w-full">

    @if($valid && $certificate)
      {{-- ✅ VALID --}}
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">

        {{-- Green header --}}
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 px-8 py-8 text-white text-center">
          <div class="text-5xl mb-3">✓</div>
          <h1 class="text-2xl font-bold">Valid Certificate</h1>
          <p class="text-green-100 mt-1 text-sm">This certificate is genuine and issued by Coursify.</p>
        </div>

        {{-- Detail sertifikat --}}
        <div class="px-8 py-8">
          <div class="grid grid-cols-1 gap-5">

            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
              <div class="text-2xl">👤</div>
              <div>
                <div class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Recipient Name</div>
                <div class="text-xl font-bold text-gray-800">{{ $certificate->user->name }}</div>
              </div>
            </div>

            <div class="flex items-start gap-4 p-4 bg-gray-50 rounded-xl">
              <div class="text-2xl">📚</div>
              <div>
                <div class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Course</div>
                <div class="text-lg font-semibold text-gray-800">{{ $certificate->course->title }}</div>
                @if($certificate->course->institution)
                  <div class="text-sm text-gray-500 mt-0.5">{{ $certificate->course->institution->name }}</div>
                @endif
              </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
              <div class="p-4 bg-gray-50 rounded-xl">
                <div class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Certificate Number</div>
                <div class="font-mono text-sm font-semibold text-gray-800">{{ $certificate->certificate_number }}</div>
              </div>
              <div class="p-4 bg-gray-50 rounded-xl">
                <div class="text-xs text-gray-500 uppercase tracking-wide mb-0.5">Issued Date</div>
                <div class="font-semibold text-gray-800">{{ $certificate->issued_at_formatted }}</div>
              </div>
            </div>

          </div>

          <div class="mt-6 pt-6 border-t border-gray-100 text-center">
            <p class="text-xs text-gray-400">
              This page is an official verification record from Coursify.<br>
              Certificate authenticity can be verified at
              <span class="font-mono">{{ url('/verify/' . $certificate->certificate_number) }}</span>
            </p>
          </div>
        </div>
      </div>

    @else
      {{-- ❌ TIDAK VALID --}}
      <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
        <div class="bg-gradient-to-r from-red-600 to-rose-500 px-8 py-8 text-white text-center">
          <div class="text-5xl mb-3">✕</div>
          <h1 class="text-2xl font-bold">Sertifikat Tidak Ditemukan</h1>
          <p class="text-red-100 mt-1 text-sm">Nomor sertifikat ini tidak terdaftar di sistem Coursify</p>
        </div>
        <div class="px-8 py-8 text-center text-gray-500">
          <p>Pastikan kamu memasukkan nomor sertifikat dengan benar.</p>
          <p class="mt-2 text-sm">Format yang benar: <span class="font-mono bg-gray-100 px-2 py-0.5 rounded">CERT-2025-XXXXXXXX</span></p>
        </div>
      </div>
    @endif

    {{-- Form cari sertifikat lain --}}
    <div class="mt-6 bg-white rounded-2xl shadow px-8 py-6">
      <h2 class="text-base font-semibold text-gray-700 mb-4">Verify another certificate</h2>
      <form action="{{ route('certificates.verify.form') }}" method="GET" class="flex gap-3">
        <input
          type="text"
          name="number"
          placeholder="Example: CERT-2025-ABCD1234"
          class="flex-1 border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
        >
        <button
          type="submit"
          class="bg-blue-600 text-white px-5 py-2.5 rounded-xl text-sm font-medium hover:bg-blue-700 transition"
        >
          Search
        </button>
      </form>
    </div>

  </div>
</div>
@endsection
