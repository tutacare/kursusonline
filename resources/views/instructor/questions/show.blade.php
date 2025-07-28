@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Question Details: {{ $question->question_text }}</h1>

    <div class="card">
        <div class="card-header">
            Question Information
        </div>
        <div class="card-body">
            <h5 class="card-title">Question Text: {{ $question->question_text }}</h5>
            <p class="card-text"><strong>Question Type:</strong> {{ $question->question_type }}</p>
            <p class="card-text"><strong>Quiz:</strong> {{ $quiz->title }}</p>
        </div>
    </div>

    <h2 class="mt-4">Answers</h2>
    <a href="{{ route('instructor.questions.answers.create', $question->id) }}" class="btn btn-primary mb-3">Add New Answer</a>

    @if ($question->answers->isEmpty())
        <p>No answers found for this question.</p>
    @else
        <ul class="list-group">
            @foreach ($question->answers as $answer)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $answer->answer_text }}
                    @if ($answer->is_correct)
                        <span class="badge badge-success">Correct</span>
                    @endif
                    <div>
                        <a href="{{ route('instructor.questions.answers.edit', [$question->id, $answer->id]) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('instructor.questions.answers.destroy', [$question->id, $answer->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('instructor.quizzes.questions.index', $quiz->id) }}" class="btn btn-secondary mt-3">Back to Questions</a>
</div>
@endsection
