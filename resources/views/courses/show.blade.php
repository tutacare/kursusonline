@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('courses.index') }}" class="hover:underline">Kursus</a>
    <span class="mx-2">></span>
    <span>{{ $course->name }}</span>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Course Details</h1>

            <div class="mb-4">
                <h5 class="text-xl font-semibold text-gray-700">Course Name:</h5>
                <p class="text-gray-900 text-lg">{{ $course->name }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-xl font-semibold text-gray-700">Description:</h5>
                <p class="text-gray-900 text-lg">{{ $course->description ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-xl font-semibold text-gray-700">Instructor:</h5>
                <p class="text-gray-900 text-lg">{{ $course->instructor->name ?? 'N/A' }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-xl font-semibold text-gray-700">Status:</h5>
                <p class="text-gray-900 text-lg">{{ ucfirst($course->status) }}</p>
            </div>

            <div class="mb-6">
                <h5 class="text-xl font-semibold text-gray-700">Price:</h5>
                <p class="text-gray-900 text-lg">Rp. {{ number_format($course->price, 2, ',', '.') }}</p>
            </div>

            <div class="mb-6">
                <h5 class="text-xl font-semibold text-gray-700">Cover Image:</h5>
                @if ($course->cover_image)
                    <img src="{{ asset('images/courses/' . $course->cover_image) }}" alt="Course Cover" class="mt-2" style="max-width: 300px;">
                @else
                    <p class="text-gray-900 text-lg">N/A</p>
                @endif
            </div>

            <a href="{{ route('courses.index') }}"
                class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                Back to Courses
            </a>
            @if (Auth::user()->hasRole('instructor') && Auth::user()->id == $course->instructor_id)
                <a href="{{ route('instructor.courses.modules.index', $course->id) }}"
                    class="ml-4 bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out">
                    Manage Modules
                </a>
            @endif
        </div>
    </div>
@endsection