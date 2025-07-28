<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $quiz->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="w-full h-full flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <h3 class="text-2xl font-bold mb-4">{{ $quiz->title }}</h3>
            <p class="text-gray-700 mb-4">{{ $quiz->description }}</p>
            <div class="mb-6">
                <strong>Petunjuk:</strong>
                <p>Silakan baca setiap pertanyaan dengan seksama dan pilih jawaban yang paling tepat.</p>
                <p>Anda memiliki waktu {{ $quiz->duration }} menit untuk menyelesaikan kuis ini.</p>
            </div>

            <div id="quiz-start-section" class="text-center flex justify-center space-x-4">
                <button id="startButton"
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-lg text-xl">Mulai
                    Kuis</button>
                <a href="{{ url()->previous() }}"
                    class="bg-red-500 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-lg text-xl">
                    Batal
                </a>
            </div>

            <div id="quiz-section" style="display: none;">
                <div class="text-right mb-4">
                    Waktu tersisa: <span id="time"></span>
                </div>

                @if ($shuffledQuestions->isEmpty())
                    <p>Belum ada pertanyaan untuk kuis ini.</p>
                @else
                    <h4 class="text-xl font-semibold mb-4">Pertanyaan:</h4>
                    <form id="quizForm" action="{{ route('student.quizzes.submit', $quiz->encrypted_id) }}"
                        method="POST">
                        @csrf
                        @foreach ($shuffledQuestions as $question)
                            <div class="quiz-question mb-6 p-4 border rounded-lg shadow-sm"
                                data-question-index="{{ $loop->index }}" style="display: none;">
                                <p class="font-bold mb-2">{{ $loop->iteration }}. {{ $question->question_text }}
                                </p>
                                @if ($question->answers->isEmpty())
                                    <p>Belum ada pilihan jawaban untuk pertanyaan ini.</p>
                                @else
                                    @foreach ($question->answers as $answer)
                                        <div class="flex items-center mb-2">
                                            <input type="radio" name="question_{{ $question->id }}"
                                                id="answer_{{ $answer->id }}" value="{{ $answer->id }}"
                                                class="mr-2">
                                            <label for="answer_{{ $answer->id }}">{{ $answer->answer_text }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        @endforeach

                        <div id="question-navigation" class="flex flex-wrap justify-center gap-2 mb-4"></div>

                        <div class="flex justify-between mt-4">
                            <button type="button" id="backButton"
                                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                                style="display: none;">Back</button>
                            <button type="button" id="nextButton"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Next</button>
                            <button type="submit" id="submitButton"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded"
                                style="display: none;">Submit Quiz</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
    </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startButton = document.getElementById('startButton');
            const quizStartSection = document.getElementById('quiz-start-section');
            const quizSection = document.getElementById('quiz-section');
            const quizForm = document.getElementById('quizForm');
            const questions = document.querySelectorAll('.quiz-question');
            const backButton = document.getElementById('backButton');
            const nextButton = document.getElementById('nextButton');
            const submitButton = document.getElementById('submitButton');
            const timeDisplay = document.getElementById('time');
            const questionNavigation = document.getElementById('question-navigation');

            let currentQuestionIndex = 0;
            let timeLeft;
            const quizId = {{ $quiz->id }};
            const quizEncryptedId = '{{ $quiz->encrypted_id }}';
            const quizDuration = {{ $quiz->duration }} * 60;

            let timerInterval;
            let startedAt;
            let answers = {};

            function formatTime(seconds) {
                const minutes = Math.floor(seconds / 60);
                const remainingSeconds = seconds % 60;
                return `${minutes.toString().padStart(2, '0')}:${remainingSeconds.toString().padStart(2, '0')}`;
            }

            function startTimer() {
                timerInterval = setInterval(() => {
                    timeLeft--;
                    timeDisplay.textContent = formatTime(timeLeft);
                    localStorage.setItem(`quiz_${quizId}_timeLeft`, timeLeft);

                    if (timeLeft <= 0) {
                        clearInterval(timerInterval);
                        quizForm.submit();
                        alert('Waktu habis! Kuis otomatis disubmit.');
                    }
                }, 1000);
            }

            function showQuestion(index) {
                questions.forEach((question, i) => {
                    question.style.display = (i === index) ? 'block' : 'none';
                });

                backButton.style.display = (index > 0) ? 'block' : 'none';
                nextButton.style.display = (index < questions.length - 1) ? 'block' : 'none';
                submitButton.style.display = (index === questions.length - 1) ? 'block' : 'none';

                updateNavigation();
            }

            function createNavigation() {
                questionNavigation.innerHTML = ''; // Clear existing navigation
                questions.forEach((_, index) => {
                    const navBox = document.createElement('div');
                    navBox.textContent = index + 1;
                    navBox.classList.add('w-8', 'h-8', 'flex', 'items-center', 'justify-center',
                        'border', 'rounded', 'cursor-pointer', 'text-white');
                    navBox.addEventListener('click', () => {
                        currentQuestionIndex = index;
                        showQuestion(currentQuestionIndex);
                    });
                    questionNavigation.appendChild(navBox);
                });
                updateNavigation();
            }

            function updateNavigation() {
                const navBoxes = questionNavigation.children;
                for (let i = 0; i < navBoxes.length; i++) {
                    if (answers[i]) {
                        navBoxes[i].classList.remove('bg-red-500');
                        navBoxes[i].classList.add('bg-green-500');
                    } else {
                        navBoxes[i].classList.remove('bg-green-500');
                        navBoxes[i].classList.add('bg-red-500');
                    }
                }
            }

            startButton.addEventListener('click', function() {
                fetch(`/quizzes/${quizEncryptedId}/start`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        throw new Error(data.error);
                    }
                    startedAt = new Date(data.started_at).getTime();
                    const now = new Date().getTime();
                    const elapsedSeconds = Math.floor((now - startedAt) / 1000);
                    timeLeft = quizDuration - elapsedSeconds;

                    if (timeLeft <= 0) {
                        alert('Waktu pengerjaan kuis telah habis.');
                        // Optionally submit form or redirect
                        return;
                    }

                    localStorage.setItem(`quiz_${quizId}_startedAt`, startedAt);
                    localStorage.setItem(`quiz_${quizId}_quizDuration`, quizDuration);
                    localStorage.setItem(`quiz_${quizId}_timeLeft`, timeLeft);

                    quizStartSection.style.display = 'none';
                    quizSection.style.display = 'block';
                    startTimer();
                    createNavigation();
                    showQuestion(currentQuestionIndex);

                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen().catch(err => {
                            console.log(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error starting quiz:', error);
                    alert('Terjadi kesalahan saat memulai kuis. Silakan coba lagi.');
                });
            });

            const storedStartedAt = localStorage.getItem(`quiz_${quizId}_startedAt`);
            const storedQuizDuration = localStorage.getItem(`quiz_${quizId}_quizDuration`);

            if (storedStartedAt && storedQuizDuration) {
                startedAt = parseInt(storedStartedAt);
                const now = new Date().getTime();
                const elapsedSeconds = Math.floor((now - startedAt) / 1000);
                timeLeft = parseInt(storedQuizDuration) - elapsedSeconds;

                if (timeLeft > 0) {
                    quizStartSection.style.display = 'none';
                    quizSection.style.display = 'block';
                    startTimer();
                    createNavigation();
                    showQuestion(currentQuestionIndex);
                } else {
                    localStorage.removeItem(`quiz_${quizId}_startedAt`);
                    localStorage.removeItem(`quiz_${quizId}_quizDuration`);
                    localStorage.removeItem(`quiz_${quizId}_timeLeft`);
                    alert('Waktu pengerjaan kuis telah habis.');
                    timeDisplay.textContent = formatTime(0);
                }
            } else {
                timeDisplay.textContent = formatTime(quizDuration);
            }

            document.addEventListener('fullscreenchange', function() {
                if (!document.fullscreenElement) {
                    alert('Anda tidak dapat keluar dari mode layar penuh sebelum kuis selesai.');
                    if (document.documentElement.requestFullscreen) {
                        document.documentElement.requestFullscreen().catch(err => {
                             console.log(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
                        });
                    }
                }
            });

            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' || (e.ctrlKey && e.key === 'w') || (e.altKey && e.key === 'F4')) {
                    e.preventDefault();
                    alert('Tindakan ini tidak diizinkan selama kuis berlangsung.');
                }
            });

            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
                alert('Tindakan ini tidak diizinkan selama kuis berlangsung.');
            });

            nextButton.addEventListener('click', function() {
                if (currentQuestionIndex < questions.length - 1) {
                    currentQuestionIndex++;
                    showQuestion(currentQuestionIndex);
                }
            });

            backButton.addEventListener('click', function() {
                if (currentQuestionIndex > 0) {
                    currentQuestionIndex--;
                    showQuestion(currentQuestionIndex);
                }
            });

            quizForm.addEventListener('change', function(e) {
                if (e.target.type === 'radio') {
                    const questionIndex = e.target.closest('.quiz-question').dataset.questionIndex;
                    answers[questionIndex] = e.target.value;
                    updateNavigation();
                }
            });
        });
    </script>
</body>

</html>