@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('courses.index') }}" class="hover:underline">Courses</a>
    <span class="mx-2">></span>
    <a href="{{ route('courses.show', $course) }}" class="hover:underline">{{ $course->name }}</a>
    <span class="mx-2">></span>
    <span>Modules</span>
@endsection

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modules for Course: ') }} {{ $course->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg::px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('instructor.courses.modules.create', $course->encrypted_id) }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Add New Module
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                            role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Order
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Title
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($modules as $module)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $module->order }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            {{ $module->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <a href="{{ route('instructor.courses.modules.show', [$course->encrypted_id, $module->encrypted_id]) }}"
                                                class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                            <a href="{{ route('instructor.courses.modules.edit', [$course->encrypted_id, $module->encrypted_id]) }}"
                                                class="text-green-600 hover:text-green-900 mr-3">Edit</a>
                                            <a href="{{ route('instructor.modules.quizzes.index', $module->encrypted_id) }}"
                                                class="text-blue-600 hover:text-blue-900 mr-3">Manage Quizzes</a>
                                            <form
                                                action="{{ route('instructor.courses.modules.destroy', [$course->encrypted_id, $module->encrypted_id]) }}"
                                                method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900"
                                                    onclick="return confirm('Are you sure you want to delete this module?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 whitespace-nowrap text-center text-gray-500">
                                            No modules found for this course.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
