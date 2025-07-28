<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Question: ') }} {{ $question->question_text }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('instructor.courses.modules.quizzes.questions.update', [$course->id, $module->id, $quiz->id, $question->id]) }}">
                        @csrf
                        @method('PUT')

                        <!-- Question Text -->
                        <div>
                            <x-input-label for="question_text" :value="__('Question Text')" />
                            <x-textarea id="question_text" class="block mt-1 w-full" name="question_text" required autofocus>{{ old('question_text', $question->question_text) }}</x-textarea>
                            <x-input-error :messages="$errors->get('question_text')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Update Question') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>