@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Answer Details: {{ $answer->answer_text }}</h1>

    <div class="card">
        <div class="card-header">
            Answer Information
        </div>
        <div class="card-body">
            <h5 class="card-title">Answer Text: {{ $answer->answer_text }}</h5>
            <p class="card-text"><strong>Is Correct:</strong>
                @if ($answer->is_correct)
                    <span class="badge badge-success">Yes</span>
                @else
                    <span class="badge badge-danger">No</span>
                @endif
            </p>
            <p class="card-text"><strong>Question:</strong> {{ $question->question_text }}</p>
        </div>
    </div>

    <a href="{{ route('instructor.questions.answers.index', $question->id) }}" class="btn btn-secondary mt-3">Back to Answers</a>
</div>
@endsection
