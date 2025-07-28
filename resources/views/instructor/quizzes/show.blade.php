@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Quiz Details: {{ $quiz->title }}</h1>

    <div class="card">
        <div class="card-header">
            Quiz Information
        </div>
        <div class="card-body">
            <h5 class="card-title">Title: {{ $quiz->title }}</h5>
            <p class="card-text"><strong>Description:</strong> {{ $quiz->description }}</p>
            <p class="card-text"><strong>Duration:</strong> {{ $quiz->duration }} minutes</p>
            <p class="card-text"><strong>Module:</strong> {{ $module->title }}</p>
        </div>
    </div>

    <h2 class="mt-4">Questions</h2>
    <a href="{{ route('instructor.quizzes.questions.create', $quiz->id) }}" class="btn btn-primary mb-3">Add New Question</a>

    @if ($quiz->questions->isEmpty())
        <p>No questions found for this quiz.</p>
    @else
        <ul class="list-group">
            @foreach ($quiz->questions as $question)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $question->question_text }}
                    <div>
                        <a href="{{ route('instructor.questions.answers.index', $question->id) }}" class="btn btn-info btn-sm">Manage Answers</a>
                        <a href="{{ route('instructor.quizzes.questions.edit', [$quiz->id, $question->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('instructor.quizzes.questions.destroy', [$quiz->id, $question->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('instructor.modules.quizzes.index', $module->id) }}" class="btn btn-secondary mt-3">Back to Quizzes</a>
</div>
@endsection
