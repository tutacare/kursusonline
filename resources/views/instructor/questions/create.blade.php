@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Question for Quiz: {{ $quiz->title }}</h1>

            <form action="{{ route('instructor.quizzes.questions.store', $quiz->encrypted_id) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="question_text" class="block text-gray-700 text-sm font-bold mb-2">Question
                        Text:</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question_text') border-red-500 @enderror"
                        id="question_text" name="question_text" rows="5" required>{{ old('question_text') }}</textarea>
                    @error('question_text')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="question_type" class="block text-gray-700 text-sm font-bold mb-2">Question
                        Type:</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('question_type') border-red-500 @enderror"
                        id="question_type" name="question_type" required>
                        <option value="multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'selected' : '' }}>
                            Multiple Choice
                        </option>
                        <option value="true_false" {{ old('question_type') == 'true_false' ? 'selected' : '' }}>
                            True/False</option>
                        <option value="short_answer" {{ old('question_type') == 'short_answer' ? 'selected' : '' }}>
                            Short Answer</option>
                    </select>
                    @error('question_type')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">
                        Create Question
                    </button>
                    <a href="{{ route('instructor.quizzes.questions.index', $quiz->encrypted_id) }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
