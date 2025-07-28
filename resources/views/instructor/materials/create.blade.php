@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('courses.index') }}" class="hover:underline">Courses</a>
    <span class="mx-2">></span>
    <a href="{{ route('instructor.courses.modules.index', $course) }}" class="hover:underline">{{ $course->name }} Modules</a>
    <span class="mx-2">></span>
    <a href="{{ route('instructor.courses.modules.materials.index', [$course, $module]) }}"
        class="hover:underline">{{ $module->title }} Materials</a>
    <span class="mx-2">></span>
    <span>Add Material</span>
@endsection

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-lg rounded-lg overflow-hidden p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-6">Add Material to {{ $module->title }}</h1>

            <form
                action="{{ route('instructor.courses.modules.materials.store', [$course->encrypted_id, $module->encrypted_id]) }}"
                method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title:</label>
                    <input type="text"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror"
                        id="title" name="title" value="{{ old('title') }}" required>
                    @error('title')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="order" class="block text-gray-700 text-sm font-bold mb-2">Order:</label>
                    <input type="number"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('order') border-red-500 @enderror"
                        id="order" name="order" value="{{ old('order') }}" required>
                    @error('order')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Type:</label>
                    <select
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('type') border-red-500 @enderror"
                        id="type" name="type" required>
                        <option value="pdf" {{ old('type') == 'pdf' ? 'selected' : '' }}>PDF</option>
                        <option value="video" {{ old('type') == 'video' ? 'selected' : '' }}>Video</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div id="file-upload-section" class="mb-6">
                    <label for="file" class="block text-gray-700 text-sm font-bold mb-2">File (PDF):</label>
                    <input type="file"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('file') border-red-500 @enderror"
                        id="file" name="file">
                    @error('file')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div id="youtube-url-section" class="mb-6" style="display: none;">
                    <label for="youtube_url" class="block text-gray-700 text-sm font-bold mb-2">YouTube URL:</label>
                    <input type="url"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('youtube_url') border-red-500 @enderror"
                        id="youtube_url" name="youtube_url" value="{{ old('youtube_url') }}">
                    @error('youtube_url')
                        <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300 ease-in-out focus:outline-none focus:shadow-outline">
                        Add Material
                    </button>
                    <a href="{{ route('instructor.courses.modules.materials.index', [$course->encrypted_id, $module->encrypted_id]) }}"
                        class="inline-block align-baseline font-bold text-sm text-blue-600 hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const typeSelect = document.getElementById('type');
            const fileUploadSection = document.getElementById('file-upload-section');
            const youtubeUrlSection = document.getElementById('youtube-url-section');
            const fileInput = document.getElementById('file');
            const youtubeUrlInput = document.getElementById('youtube_url');

            function toggleInputFields() {
                if (typeSelect.value === 'pdf') {
                    fileUploadSection.style.display = 'block';
                    youtubeUrlSection.style.display = 'none';
                    fileInput.setAttribute('required', 'required');
                    youtubeUrlInput.removeAttribute('required');
                } else if (typeSelect.value === 'video') {
                    fileUploadSection.style.display = 'none';
                    youtubeUrlSection.style.display = 'block';
                    fileInput.removeAttribute('required');
                    youtubeUrlInput.setAttribute('required', 'required');
                }
            }

            typeSelect.addEventListener('change', toggleInputFields);

            // Initial call to set the correct fields based on default or old value
            toggleInputFields();
        });
    </script>
@endpush
