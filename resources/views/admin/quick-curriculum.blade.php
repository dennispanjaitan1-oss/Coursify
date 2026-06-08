{{-- resources/views/admin/quick-curriculum.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex">

    {{-- SIDEBAR --}}
    @include('admin.partials.sidebar')

    <main class="flex-1 p-8 overflow-y-auto">

            @php($breadcrumb = 'Quick Curriculum')
            @include('admin.partials.header')

        {{-- HEADER --}}
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Smart Curriculum Parser</h1>
                <p class="text-gray-500 mt-2">Salin & Tempel kurikulum utuh langsung dari edX. Sistem akan otomatis memecah menjadi Section & Lesson.</p>
            </div>
            <div class="bg-indigo-100 text-indigo-700 px-4 py-2 rounded-2xl text-sm font-semibold">
                ✨ Auto-Parser Active
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-xl"></i>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl flex items-center gap-3">
                <i class="fa-solid fa-circle-exclamation text-xl"></i>
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
            
            {{-- INPUT FORM --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex flex-col justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center gap-2">
                        <i class="fa-solid fa-paste text-orange-500"></i> Input Kurikulum Mentah
                    </h2>

                    <form action="{{ route('admin.quick-curriculum.store') }}" method="POST" id="curriculumForm">
                        @csrf
                        
                        {{-- Select Course --}}
                        <div class="mb-6">
                            <label for="course_id" class="block text-sm font-medium text-gray-700 mb-2">Pilih Kursus</label>
                            <select name="course_id" id="course_id" required 
                                    class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 text-gray-700">
                                <option value="">-- Pilih Kursus --</option>
                                @foreach($courses as $course)
                                    <option value="{{ $course->id }}">{{ $course->title }} ({{ $course->slug }})</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Paste Textarea --}}
                        <div class="mb-6">
                            <label for="raw_text" class="block text-sm font-medium text-gray-700 mb-2">Paste Seluruh Teks Kurikulum edX di Sini</label>
                            <textarea id="raw_text" rows="15" placeholder="Contoh:&#10;Week 1: Introduction to Coding&#10;Video&#10;Welcome to CS50&#10;Reading&#10;Getting Started&#10;Week 2: Loops&#10;Video&#10;What are loops"
                                      class="w-full bg-gray-50 border border-gray-200 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-orange-500 font-mono text-sm text-gray-700 placeholder-gray-400"></textarea>
                        </div>

                        <input type="hidden" name="curriculum_data" id="curriculum_data">
                    </form>
                </div>

                <div>
                    <button type="button" onclick="submitCurriculumForm()" id="submitBtn" disabled
                            class="w-full bg-gray-300 text-gray-500 cursor-not-allowed font-semibold p-4 rounded-2xl transition duration-200 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Kurikulum ke Database
                    </button>
                </div>
            </div>

            {{-- LIVE PREVIEW --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-50 flex flex-col">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center justify-between">
                    <span class="flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass text-indigo-500"></i> Hasil Live Preview
                    </span>
                    <span class="text-xs bg-gray-100 text-gray-500 px-3 py-1 rounded-full font-medium" id="statsDisplay">
                        0 Section · 0 Lesson
                    </span>
                </h2>

                <div class="flex-1 bg-gray-50 border border-dashed border-gray-200 rounded-2xl p-6 overflow-y-auto max-h-[550px]" id="previewContainer">
                    <div class="h-full flex flex-col items-center justify-center text-center text-gray-400">
                        <i class="fa-solid fa-wand-magic-sparkles text-4xl mb-4 text-gray-300"></i>
                        <p class="font-medium text-sm">Menunggu input teks...</p>
                        <p class="text-xs text-gray-400 mt-1">Hasil pengenalan otomatis akan tampil langsung di sini.</p>
                    </div>
                </div>
            </div>

        </div>

    </main>
</div>

<script>
    const rawTextEl = document.getElementById('raw_text');
    const previewContainer = document.getElementById('previewContainer');
    const statsDisplay = document.getElementById('statsDisplay');
    const submitBtn = document.getElementById('submitBtn');
    const courseSelect = document.getElementById('course_id');
    const hiddenDataInput = document.getElementById('curriculum_data');

    let parsedData = [];

    // Smart Auto-Parser function
    function parseCurriculum(text) {
        if (!text.trim()) return [];

        const lines = text.split('\n');
        const sections = [];
        let currentSection = null;
        let sectionOrder = 1;
        let lessonOrder = 1;

        function isMetadata(line) {
            line = line.trim().toLowerCase();
            if (!line) return true;
            
            const skips = [
                'video', 'reading', 'quiz', 'practice', 'graded', 'estimated', 'duration',
                'expand', 'collapse', 'expand all', 'collapse all', 'topics', 'lessons', 
                'minutes', 'hours', 'mins', 'hrs', 'free preview', 'core topic', 'survey',
                'video lecture', 'ungraded'
            ];
            if (skips.includes(line)) return true;

            // Skip "X topics", "X lessons", "15 minutes" etc
            if (/^\d+\s+(topics?|lessons?|minutes?|hours?|mins?|hrs?|videos?|readings?|quizzes?)$/i.test(line)) {
                return true;
            }

            // Skip "10m", "1h 30m"
            if (/^\d+\s*(m|h|min|mins|hour|hours|sec|secs)$/i.test(line)) {
                return true;
            }

            return false;
        }

        lines.forEach(line => {
            const cleanLine = line.trim();
            if (!cleanLine) return;

            let isSection = false;
            let sectionTitle = cleanLine;

            // Match pattern "Section 1: Intro", "Module 2 - C", "Week 3", "1. Introduction"
            const secRegex = /^(section|module|week|bagian|bab|unit|chapter|\d+)\s*(?:\d+)?\s*[:\-\.\s]\s*(.*)$/i;
            const secRegex2 = /^(section|module|week|bagian|bab|unit|chapter)\s*(\d+)$/i;

            if (secRegex.test(cleanLine)) {
                const matches = cleanLine.match(secRegex);
                isSection = true;
                sectionTitle = matches[2] ? matches[2].trim() : cleanLine;
            } else if (secRegex2.test(cleanLine)) {
                isSection = true;
                sectionTitle = cleanLine;
            }

            if (isSection) {
                currentSection = {
                    title: sectionTitle,
                    order_index: sectionOrder++,
                    lessons: []
                };
                sections.push(currentSection);
                lessonOrder = 1;
            } else {
                if (!isMetadata(cleanLine)) {
                    // Create default section if none exists
                    if (!currentSection) {
                        currentSection = {
                            title: "Bagian 1: Pendahuluan",
                            order_index: sectionOrder++,
                            lessons: []
                        };
                        sections.push(currentSection);
                    }
                    
                    // Clean lesson title: remove leading "Lesson 1.1:" or "1. Welcome"
                    const cleanLesson = cleanLine.replace(/^(lesson|materi)?\s*(?:\d+\.\d+|\d+)\s*[:\-\.\s]\s*/i, '');
                    
                    currentSection.lessons.push({
                        title: cleanLesson,
                        order_index: lessonOrder++
                    });
                }
            }
        });

        return sections;
    }

    // Update live preview HTML
    function updatePreview() {
        const text = rawTextEl.value;
        parsedData = parseCurriculum(text);

        if (parsedData.length === 0) {
            previewContainer.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-center text-gray-400">
                    <i class="fa-solid fa-wand-magic-sparkles text-4xl mb-4 text-gray-300"></i>
                    <p class="font-medium text-sm">Menunggu input teks...</p>
                    <p class="text-xs text-gray-400 mt-1">Hasil pengenalan otomatis akan tampil langsung di sini.</p>
                </div>
            `;
            statsDisplay.innerText = "0 Section · 0 Lesson";
            submitBtn.disabled = true;
            submitBtn.className = "w-full bg-gray-300 text-gray-500 cursor-not-allowed font-semibold p-4 rounded-2xl flex items-center justify-center gap-2";
            return;
        }

        let lessonCount = 0;
        let html = '<div class="space-y-4">';

        parsedData.forEach(sec => {
            lessonCount += sec.lessons.length;
            html += `
                <div class="bg-white border border-gray-100 rounded-2xl p-4 shadow-sm">
                    <div class="flex items-center gap-2 mb-3">
                        <span class="bg-orange-100 text-orange-600 text-xs px-2.5 py-1 rounded-lg font-bold">
                            SEC ${sec.order_index}
                        </span>
                        <h3 class="font-bold text-gray-800">${sec.title}</h3>
                    </div>
                    <div class="space-y-2 pl-4 border-l-2 border-orange-200">
            `;

            if (sec.lessons.length === 0) {
                html += `<p class="text-xs text-gray-400 italic">Belum ada materi di section ini</p>`;
            } else {
                sec.lessons.forEach(les => {
                    html += `
                        <div class="flex items-center gap-2 text-sm text-gray-600">
                            <span class="text-indigo-400 text-xs font-semibold">#${les.order_index}</span>
                            <span>${les.title}</span>
                        </div>
                    `;
                });
            }

            html += `
                    </div>
                </div>
            `;
        });

        html += '</div>';
        previewContainer.innerHTML = html;
        statsDisplay.innerText = `${parsedData.length} Section · ${lessonCount} Lesson`;

        // Handle button activation
        checkFormStatus();
    }

    function checkFormStatus() {
        const isCourseSelected = courseSelect.value !== "";
        const hasData = parsedData.length > 0;

        if (isCourseSelected && hasData) {
            submitBtn.disabled = false;
            submitBtn.className = "w-full bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-semibold p-4 rounded-2xl shadow-md transition duration-200 flex items-center justify-center gap-2 transform hover:-translate-y-0.5 active:translate-y-0 cursor-pointer";
        } else {
            submitBtn.disabled = true;
            submitBtn.className = "w-full bg-gray-300 text-gray-500 cursor-not-allowed font-semibold p-4 rounded-2xl flex items-center justify-center gap-2";
        }
    }

    function submitCurriculumForm() {
        if (parsedData.length === 0 || !courseSelect.value) return;
        
        hiddenDataInput.value = JSON.stringify(parsedData);
        document.getElementById('curriculumForm').submit();
    }

    // Attach Event Listeners
    rawTextEl.addEventListener('input', updatePreview);
    courseSelect.addEventListener('change', checkFormStatus);
</script>
@endsection
