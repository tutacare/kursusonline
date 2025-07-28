<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Answer;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    public function index(Question $question)
    {
        $answers = $question->answers;
        return view('instructor.answers.index', compact('question', 'answers'));
    }

    public function create(Question $question)
    {
        return view('instructor.answers.create', compact('question'));
    }

    public function store(Request $request, Question $question)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'is_correct' => 'boolean',
        ]);

        $question->answers()->create($request->all());

        return redirect()->route('instructor.questions.answers.index', $question->encrypted_id)
            ->with('success', 'Answer created successfully.');
    }

    public function show(Question $question, Answer $answer)
    {
        return view('instructor.answers.show', compact('question', 'answer'));
    }

    public function edit(Question $question, Answer $answer)
    {
        return view('instructor.answers.edit', compact('question', 'answer'));
    }

    public function update(Request $request, Question $question, Answer $answer)
    {
        $request->validate([
            'answer_text' => 'required|string',
            'is_correct' => 'boolean',
        ]);

        $answer->update($request->all());

        return redirect()->route('instructor.questions.answers.index', $question->encrypted_id)
            ->with('success', 'Answer updated successfully.');
    }

    public function destroy(Question $question, Answer $answer)
    {
        $answer->delete();

        return redirect()->route('instructor.questions.answers.index', $question->encrypted_id)
            ->with('success', 'Answer deleted successfully.');
    }
}
