<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Module Details: ') }} {{ $module->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>Course:</strong> {{ $course->name }}
                    </div>
                    <div class="mb-4">
                        <strong>Title:</strong> {{ $module->title }}
                    </div>
                    <div class="mb-4">
                        <strong>Order:</strong> {{ $module->order }}
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('instructor.courses.modules.index', $course->encrypted_id) }}"
                            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Modules
                        </a>
                        <a href="{{ route('instructor.courses.modules.edit', [$course->encrypted_id, $module->encrypted_id]) }}"
                            class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Module
                        </a>
                        <a href="{{ route('instructor.courses.modules.materials.index', [$course->encrypted_id, $module->encrypted_id]) }}"
                            class="ml-4 bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Manage Materials
                        </a>
                        <a href="{{ route('instructor.modules.quizzes.index', $module->encrypted_id) }}"
                            class="ml-4 bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Manage Quizzes
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
