<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index(Quiz $quiz)
    {
        $questions = $quiz->questions;
        return view('instructor.questions.index', compact('quiz', 'questions'));
    }

    public function create(Quiz $quiz)
    {
        return view('instructor.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        $quiz->questions()->create($request->all());

        return redirect()->route('instructor.quizzes.questions.index', $quiz->encrypted_id)
            ->with('success', 'Question created successfully.');
    }

    public function show(Quiz $quiz, Question $question)
    {
        return view('instructor.questions.show', compact('quiz', 'question'));
    }

    public function edit(Quiz $quiz, Question $question)
    {
        return view('instructor.questions.edit', compact('quiz', 'question'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
        $request->validate([
            'question_text' => 'required|string',
            'question_type' => 'required|in:multiple_choice,true_false,short_answer',
        ]);

        $question->update($request->all());

        return redirect()->route('instructor.quizzes.questions.index', $quiz->encrypted_id)
            ->with('success', 'Question updated successfully.');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
        $question->delete();

        return redirect()->route('instructor.quizzes.questions.index', $quiz->encrypted_id)
            ->with('success', 'Question deleted successfully.');
    }
}
