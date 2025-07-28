<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index(Module $module)
    {
        $quizzes = $module->quizzes()->paginate(10);
        return view('instructor.quizzes.index', compact('module', 'quizzes'));
    }

    public function create(Module $module)
    {
        return view('instructor.quizzes.create', compact('module'));
    }

    public function store(Request $request, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $module->quizzes()->create($request->all());

        return redirect()->route('instructor.modules.quizzes.index', $module->encrypted_id)
            ->with('success', 'Quiz created successfully.');
    }

    public function show(Module $module, Quiz $quiz)
    {
        return view('instructor.quizzes.show', compact('module', 'quiz'));
    }

    public function edit(Module $module, Quiz $quiz)
    {
        return view('instructor.quizzes.edit', compact('module', 'quiz'));
    }

    public function update(Request $request, Module $module, Quiz $quiz)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'duration' => 'required|integer|min:1',
        ]);

        $quiz->update($request->all());

        return redirect()->route('instructor.modules.quizzes.index', $module->encrypted_id)
            ->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Module $module, Quiz $quiz)
    {
        $quiz->delete();

        return redirect()->route('instructor.modules.quizzes.index', $module->encrypted_id)
            ->with('success', 'Quiz deleted successfully.');
    }
}
