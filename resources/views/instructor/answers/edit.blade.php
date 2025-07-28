@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Answer: {{ $answer->answer_text }}</h1>

    <form action="{{ route('instructor.questions.answers.update', [$question->id, $answer->id]) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="answer_text">Answer Text</label>
            <textarea class="form-control" id="answer_text" name="answer_text" required>{{ old('answer_text', $answer->answer_text) }}</textarea>
            @error('answer_text')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="is_correct" name="is_correct" value="1" {{ old('is_correct', $answer->is_correct) ? 'checked' : '' }}>
            <label class="form-check-label" for="is_correct">Is Correct Answer</label>
            @error('is_correct')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Update Answer</button>
        <a href="{{ route('instructor.questions.answers.index', $question->id) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
