<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}

                    <h3 class="text-lg font-medium text-gray-900 mt-6">My Courses</h3>

                    @if ($courses->isEmpty())
                        <p class="mt-1 text-sm text-gray-600">You haven't enrolled in any courses yet.</p>
                    @else
                        <div class="mt-4 grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach ($courses as $course)
                                <div class="bg-gray-100 p-4 rounded-lg shadow">
                                    <h4 class="text-md font-semibold text-gray-800">{{ $course->title }}</h4>
                                    <p class="mt-1 text-sm text-gray-600">{{ Str::limit($course->description, 100) }}
                                    </p>
                                    <a href="{{ route('student.courses.show', $course->encrypted_id) }}"
                                        class="mt-3 inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Continue Learning
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
