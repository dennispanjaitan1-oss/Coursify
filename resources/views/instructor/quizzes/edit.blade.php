@extends('layouts.instructor')

@section('title', 'Edit Quiz')

@section('content')
    <header class="topbar" role="banner">
        <div class="topbar__search">
            <i class="fa-solid fa-magnifying-glass topbar__search-icon" aria-hidden="true"></i>
            <label for="lesson-search" class="sr-only">Search</label>
            <input type="text" id="lesson-search" class="topbar__search-input" placeholder="Search..." aria-label="Search">
        </div>

        <div class="topbar__actions">
            <a href="{{ route('instructor.quizzes.index') }}" class="icon-btn" aria-label="Back to quizzes">
                <i class="fa-solid fa-arrow-left"></i>
            </a>
        </div>
    </header>

    <section class="page-header" aria-label="Page title">
        <div>
            <h1 class="page-title">Edit Quiz</h1>
            <p class="page-subtitle">Update the quiz lesson and its questions.</p>
        </div>
    </section>

    <section class="card-wrap" aria-labelledby="quiz-edit-title">
        <div class="card-head">
            <h2 class="card-title" id="quiz-edit-title">Quiz: {{ $lesson->title }}</h2>
        </div>

        <form method="POST" action="{{ route('instructor.quizzes.update', $lesson) }}" class="quiz-form" id="editQuizForm">
            @csrf
            @method('PUT')

            @if(session('success'))
                <div class="alert alert-success" style="margin-bottom: 20px; padding: 16px; border-radius: 16px; background: #E6F4EA; color: #1F4532; border: 1px solid #C6E6CF;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger" style="margin-bottom: 20px; padding: 16px; border-radius: 16px; background: #FDECEA; color: #7C1E21; border: 1px solid #F5C2C3;">
                    <strong>Terjadi kesalahan:</strong>
                    <ul style="margin-top: 8px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group">
                <label class="form-label">Course</label>
                <div class="form-control" style="background: #F8FAFF;">{{ $lesson->section->course->title }}</div>
            </div>

            <div class="form-group">
                <label class="form-label">Section</label>
                <div class="form-control" style="background: #F8FAFF;">{{ $lesson->section->title }}</div>
            </div>

            <div class="form-group">
                <label for="lesson-title" class="form-label">Lesson Title *</label>
                <input type="text" id="lesson-title" name="lesson_title" class="form-control" value="{{ old('lesson_title', $lesson->title) }}" required>
            </div>

            <div class="form-group">
                <label for="lesson-description" class="form-label">Lesson Description</label>
                <textarea id="lesson-description" name="lesson_description" class="form-control" rows="3">{{ old('lesson_description', $lesson->content) }}</textarea>
            </div>

            <div class="form-info" style="font-size: 14px; color: #555; margin-bottom: 24px;">
                Update questions and answer options for the quiz lesson.
            </div>

            <div class="form-section-title">Questions</div>
            <div id="questionsContainer" class="questions-container"></div>

            <button type="button" class="btn-secondary" style="margin-bottom: 20px;" onclick="addQuestion()">
                <i class="fa-solid fa-plus" aria-hidden="true"></i>
                Add Another Question
            </button>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-check" aria-hidden="true"></i>
                    Save Quiz
                </button>
                <a href="{{ route('instructor.quizzes.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </section>

    <script>
        @php
            $initialQuestions = $lesson->quizzes->map(function ($quiz) {
                return [
                    'question' => $quiz->question,
                    'type' => $quiz->type,
                    'options' => $quiz->options->map(function ($option) {
                        return [
                            'text' => $option->option_text,
                            'isCorrect' => (bool)$option->is_correct,
                        ];
                    })->toArray(),
                ];
            })->values()->toArray();
        @endphp
        const initialQuestions = @json($initialQuestions);

        let questionCount = 0;

        function addQuestion(data = null) {
            const container = document.getElementById('questionsContainer');
            const index = questionCount++;
            const questionText = data?.question ?? '';
            const type = data?.type ?? 'multiple_choice';
            const options = data?.options ?? [
                { text: '', isCorrect: true },
                { text: '', isCorrect: false },
                { text: '', isCorrect: false },
                { text: '', isCorrect: false },
            ];

            const block = document.createElement('div');
            block.className = 'question-item';
            block.dataset.index = index;
            block.innerHTML = `
                <div class="question-number">Question ${index + 1}</div>
                <div class="form-group">
                    <label class="form-label" for="questions_${index}_question">Question Text *</label>
                    <textarea id="questions_${index}_question" name="questions[${index}][question]" class="form-control" rows="2" placeholder="Enter your question..." required>${questionText}</textarea>
                </div>
                <div class="form-group">
                    <label class="form-label">Question Type</label>
                    <div class="radio-group">
                        <label class="radio-option">
                            <input type="radio" name="questions[${index}][type]" value="multiple_choice" ${type === 'multiple_choice' ? 'checked' : ''}>
                            Multiple Choice
                        </label>
                        <label class="radio-option">
                            <input type="radio" name="questions[${index}][type]" value="true_false" ${type === 'true_false' ? 'checked' : ''}>
                            True/False
                        </label>
                    </div>
                </div>
                <div class="options-block" id="options-${index}">
                    <div class="form-label" style="font-weight:700; margin-bottom:10px;">Options</div>
                    ${options.map((option, optionIndex) => `
                        <div class="form-group" style="display:flex; gap:10px; align-items:flex-start; margin-bottom:10px;">
                            <label style="display:flex; align-items:center; gap:10px; flex:1;">
                                <input type="radio" name="questions[${index}][correct]" value="${optionIndex}" ${option.isCorrect ? 'checked' : ''} required>
                                <input type="text" name="questions[${index}][options][${optionIndex}][text]" class="form-control" placeholder="Option ${optionIndex + 1}" value="${option.text.replace(/"/g, '&quot;')}" required>
                            </label>
                        </div>
                    `).join('')}
                </div>
                <button type="button" class="btn-secondary" style="margin-bottom:20px;" onclick="removeQuestion(${index})">
                    <i class="fa-solid fa-trash" aria-hidden="true"></i>
                    Remove Question
                </button>
            `;

            container.appendChild(block);
        }

        function removeQuestion(index) {
            const item = document.querySelector(`.question-item[data-index="${index}"]`);
            if (item) {
                item.remove();
                refreshQuestionNumbers();
            }
        }

        function refreshQuestionNumbers() {
            const items = document.querySelectorAll('.question-item');
            items.forEach((item, idx) => {
                item.querySelector('.question-number').textContent = `Question ${idx + 1}`;
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            if (initialQuestions.length) {
                initialQuestions.forEach(question => addQuestion(question));
            } else {
                addQuestion();
            }
        });
    </script>
@endsection