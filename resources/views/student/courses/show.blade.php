@extends('layouts.app')

@section('breadcrumbs')
    <span class="mx-2">></span>
    <a href="{{ route('student.courses.index') }}" class="hover:underline">Kursus Saya</a>
    <span class="mx-2">></span>
    <span>{{ $course->name }}</span>
@endsection


@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $course->title }}
        </h2>
    </x-slot>
    @if (session('status'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <strong class="font-bold">Berhasil!</strong>
            <span class="block sm:inline">{{ session('status') }}</span>
        </div>
    @endif
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-2xl font-bold mb-4">{{ $course->name }}</h3>
                    <p class="text-gray-700 mb-6">{{ $course->description }}</p>

                    <h4 class="text-xl font-semibold mb-4">Modul Kursus</h4>
                    @if ($course->modules->isEmpty())
                        <p>Belum ada modul untuk kursus ini.</p>
                    @else
                        @foreach ($course->modules as $module)
                            <div class="mb-6 p-4 border rounded-lg shadow-sm">
                                <h5 class="text-lg font-bold mb-2">{{ $module->title }}</h5>
                                <p class="text-gray-600 mb-4">{{ $module->description }}</p>

                                @if ($module->materials->isEmpty())
                                    <p>Belum ada materi untuk modul ini.</p>
                                @else
                                    <ul class="list-disc pl-5">
                                        @foreach ($module->materials as $material)
                                            <li class="text-gray-800 mb-1">
                                                <a href="{{ route('student.materials.show', $material->encrypted_id) }}"
                                                    class="text-blue-600 hover:underline">{{ $material->title }}</a>
                                                @if ($material->type === 'video')
                                                    <span class="text-sm text-gray-500">(Video)</span>
                                                @elseif ($material->type === 'pdf')
                                                    <span class="text-sm text-gray-500">(Dokumen)</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif

                                @if ($module->quizzes->isNotEmpty())
                                    <h6 class="text-md font-semibold mt-4 mb-2">Kuis:</h6>
                                    <ul class="list-disc pl-5">
                                        @foreach ($module->quizzes as $quiz)
                                            <li class="text-gray-800 mb-1">
                                                @php
                                                    $quizResult = $quiz->quizResults->first();
                                                @endphp

                                                @if ($quizResult && $quizResult->is_completed)
                                                    <span class="text-green-600">{{ $quiz->title }} (Sudah Dikerjakan |
                                                        Skor Anda: {{ $quizResult->score }})</span>
                                                    <!-- Tambahkan Tombol Reset -->
                                                    <form
                                                        action="{{ route('student.quizzes.reset', $quiz->encrypted_id) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            onclick="return confirm('Apakah Anda yakin ingin mengulang kuis ini?')"
                                                            class="text-red-600 hover:underline ml-4">Reset Kuis</button>
                                                    </form>
                                                @else
                                                    <a href="{{ route('student.quizzes.show', $quiz->encrypted_id) }}"
                                                        class="text-green-600 hover:underline">{{ $quiz->title }}</a>
                                                    <span class="text-sm text-gray-500">(Durasi: {{ $quiz->duration }}
                                                        menit)</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
