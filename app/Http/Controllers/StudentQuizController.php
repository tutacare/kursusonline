<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Quiz;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentQuizController extends Controller
{
    public function show(Quiz $quiz)
    {
        $user = Auth::user();
        $quizResult = QuizResult::where('user_id', $user->id)
            ->where('quiz_id', $quiz->id)
            ->first();

        if ($quizResult && $quizResult->is_completed) {
            return redirect()->route('student.courses.show', $quiz->module->course->encrypted_id)->with('error', 'Anda sudah mengerjakan kuis ini. Skor Anda: ' . $quizResult->score);
        }

        // Load questions and answers, then shuffle the questions
        $quiz->load(['questions.answers']);
        $shuffledQuestions = $quiz->questions->shuffle();

        return view('student.quizzes.show', compact('quiz', 'shuffledQuestions'));
    }

    public function submit(Request $request, Quiz $quiz)
    {
        try {
            $user = Auth::user();
            $score = 0;

            foreach ($quiz->questions as $question) {
                $selectedAnswerId = $request->input('question_' . $question->id);

                if ($selectedAnswerId) {
                    $correctAnswer = $question->answers()->where('is_correct', true)->first();

                    if ($correctAnswer && $correctAnswer->id == $selectedAnswerId) {
                        $score++;
                    }
                }
            }

            $quizResult = QuizResult::updateOrCreate(
                ['user_id' => $user->id, 'quiz_id' => $quiz->id],
                [
                    'score' => $score,
                    'is_completed' => true,
                    'submitted_at' => now(),
                ]
            );

            return redirect()->route('student.courses.show', $quiz->module->course->encrypted_id)->with('success', 'Kuis berhasil disubmit! Skor Anda: ' . $score);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat submit kuis: ' . $e->getMessage());
        }
    }

    public function startQuiz(Request $request, Quiz $quiz)
    {
        try {
            $user = Auth::user();

            $quizResult = QuizResult::firstOrCreate(
                ['user_id' => $user->id, 'quiz_id' => $quiz->id],
                ['started_at' => now(), 'score' => 0, 'is_completed' => false]
            );

            return response()->json([
                'started_at' => $quizResult->started_at,
                'quiz_duration' => $quiz->duration, // Assuming Quiz model has a 'duration' attribute
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function reset(Quiz $quiz)
    {
        $quiz = Quiz::findOrFail($quiz->id);

        $quizResult = QuizResult::where('quiz_id', $quiz->id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if ($quizResult) {
            $quizResult->delete(); // Hapus hasil kuis
        }

        return redirect()->route('student.courses.show', $quiz->module->course->encrypted_id)->with('status', 'Kuis berhasil direset. Silakan mulai kembali.');
    }
}
