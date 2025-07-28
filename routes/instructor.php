<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\QuizController;
use App\Http\Controllers\Instructor\AnswerController;
use App\Http\Controllers\Instructor\ModuleController;
use App\Http\Controllers\Instructor\QuestionController;

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    // Quiz Management
    Route::resource('modules.quizzes', QuizController::class)->except(['show']);
    Route::get('modules/{module}/quizzes/{quiz}', [QuizController::class, 'show'])->name('modules.quizzes.show');

    // Question Management
    Route::resource('quizzes.questions', QuestionController::class)->except(['show']);
    Route::get('quizzes/{quiz}/questions/{question}', [QuestionController::class, 'show'])->name('quizzes.questions.show');

    // Answer Management
    Route::resource('questions.answers', AnswerController::class)->except(['show']);
    Route::get('questions/{question}/answers/{answer}', [AnswerController::class, 'show'])->name('questions.answers.show');
});
