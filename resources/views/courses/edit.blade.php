@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('courses.index') }}" class="hover:underline">Kursus</a>
    <span class="mx-2">></span>
    <a href="{{ route('courses.show', $course) }}" class="hover:underline">{{ $course->name }}</a>
    <span class="mx-2">></span>
    <span>Edit</span>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Course</h1>

            <form action="{{ route('courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Course Name:</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                        id="name" name="name" value="{{ old('name', $course->name) }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                    <textarea
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('description') border-red-500 @enderror"
                        id="description" name="description" rows="5">{{ old('description', $course->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                    <input type="number" step="0.01"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('price') border-red-500 @enderror"
                        id="price" name="price" value="{{ old('price', $course->price) }}" required>
                    @error('price')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="cover_image" class="block text-gray-700 text-sm font-bold mb-2">Cover Image:</label>
                    @if ($course->cover_image)
                        <img src="{{ asset('storage/courses/' . $course->cover_image) }}" alt="Course Cover" class="mb-2"
                            style="max-width: 200px;">
                    @endif
                    <input type="file"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('cover_image') border-red-500 @enderror"
                        id="cover_image" name="cover_image">
                    @error('cover_image')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                @if (Auth::user()->hasRole('admin'))
                    <div class="mb-4">
                        <label for="instructor_id" class="block text-gray-700 text-sm font-bold mb-2">Instructor:</label>
                        <select
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('instructor_id') border-red-500 @enderror"
                            id="instructor_id" name="instructor_id">
                            <option value="">Select Instructor</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}"
                                    {{ old('instructor_id', $course->instructor_id) == $instructor->id ? 'selected' : '' }}>
                                    {{ $instructor->name }}</option>
                            @endforeach
                        </select>
                        @error('instructor_id')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                        @enderror
                    </div>
                @endif

                <div class="mb-6">
                    <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
                    <select
                        class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('status') border-red-500 @enderror"
                        id="status" name="status" required>
                        <option value="draft" {{ old('status', $course->status) == 'draft' ? 'selected' : '' }}>Draft
                        </option>
                        <option value="publish" {{ old('status', $course->status) == 'publish' ? 'selected' : '' }}>Publish
                        </option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">
                        Update
                    </button>
                    <a href="{{ route('courses.index') }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
