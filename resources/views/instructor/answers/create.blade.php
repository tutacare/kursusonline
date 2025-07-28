@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Create New Answer for Question: {{ $question->question_text }}
            </h1>

            <form action="{{ route('instructor.questions.answers.store', $question->encrypted_id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="answer_text" class="block text-gray-700 text-sm font-bold mb-2">Answer Text:</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('answer_text') border-red-500 @enderror"
                        id="answer_text" name="answer_text" required>{{ old('answer_text') }}</textarea>
                    @error('answer_text')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-6 flex items-center">
                    <input type="checkbox" class="form-checkbox h-5 w-5 text-blue-600" id="is_correct" name="is_correct"
                        value="1" {{ old('is_correct') ? 'checked' : '' }}>
                    <label class="ml-2 block text-gray-700 text-sm font-bold" for="is_correct">Is Correct Answer</label>
                    @error('is_correct')
                        <p class="text-red-500 text-xs italic ml-4">{{ $message }}</p>
                    @enderror
                </div>
                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">Create
                        Answer</button>
                    <a href="{{ route('instructor.questions.answers.index', $question->encrypted_id) }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
