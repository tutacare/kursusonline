@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Quiz: {{ $quiz->title }}</h1>

        <form action="{{ route('instructor.modules.quizzes.update', [$module->encrypted_id, $quiz->encrypted_id]) }}"
            method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Quiz Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $quiz->title) }}"
                    required>
                @error('title')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $quiz->description) }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="duration">Duration (minutes)</label>
                <input type="number" class="form-control" id="duration" name="duration"
                    value="{{ old('duration', $quiz->duration) }}" required min="1">
                @error('duration')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Update Quiz</button>
            <a href="{{ route('instructor.modules.quizzes.index', $module->encrypted_id) }}"
                class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection
