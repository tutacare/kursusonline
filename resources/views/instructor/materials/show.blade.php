<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Material Details: ') }} {{ $material->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>Course:</strong> {{ $course->title }}
                    </div>
                    <div class="mb-4">
                        <strong>Module:</strong> {{ $module->title }}
                    </div>
                    <div class="mb-4">
                        <strong>Title:</strong> {{ $material->title }}
                    </div>
                    <div class="mb-4">
                        <strong>Type:</strong> {{ $material->type }}
                    </div>
                    <div class="mb-4">
                        <strong>Content:</strong>
                        @if ($material->content)
                            <a href="{{ Storage::url($material->content) }}" target="_blank" class="text-blue-600 hover:text-blue-900">
                                View {{ strtoupper($material->type) }}
                            </a>
                        @else
                            No file uploaded.
                        @endif
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="{{ route('instructor.courses.modules.materials.index', [$course->id, $module->id]) }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                            Back to Materials
                        </a>
                        <a href="{{ route('instructor.courses.modules.materials.edit', [$course->id, $module->id, $material->id]) }}" class="ml-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit Material
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>