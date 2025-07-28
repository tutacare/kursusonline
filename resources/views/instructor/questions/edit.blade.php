@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Question: {{ $question->question_text }}</h1>

    <form action="{{ route('instructor.quizzes.questions.update', [$quiz->id, $question->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="question_text">Question Text</label>
            <textarea class="form-control" id="question_text" name="question_text" required>{{ old('question_text', $question->question_text) }}</textarea>
            @error('question_text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="question_type">Question Type</label>
            <select class="form-control" id="question_type" name="question_type" required>
                <option value="multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}>Multiple Choice</option>
                <option value="true_false" {{ old('question_type', $question->question_type) == 'true_false' ? 'selected' : '' }}>True/False</option>
                <option value="short_answer" {{ old('question_type', $question->question_type) == 'short_answer' ? 'selected' : '' }}>Short Answer</option>
            </select>
            @error('question_type')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Question</button>
        <a href="{{ route('instructor.quizzes.questions.index', $quiz->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
