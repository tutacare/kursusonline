<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Instructor\ModuleController;
use App\Http\Controllers\Instructor\MaterialController;
use App\Http\Controllers\Instructor\QuizController;
use App\Http\Controllers\Instructor\QuestionController;
use App\Http\Controllers\Instructor\AnswerController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\StudentMaterialController;
use App\Http\Controllers\StudentQuizController;
use App\Http\Controllers\SitemapController;

use App\Models\Course;

use App\Http\Controllers\PublicCourseController;

Route::get('/', [PublicCourseController::class, 'index'])->name('courses.index');

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/my-courses', [App\Http\Controllers\StudentCourseController::class, 'index'])->name('student.courses.index');
    Route::get('/my-courses/{course}', [App\Http\Controllers\StudentCourseController::class, 'show'])->name('student.courses.show');
    Route::resource('users', App\Http\Controllers\UserController::class);
    Route::resource('roles', App\Http\Controllers\RoleController::class);
    Route::resource('permissions', App\Http\Controllers\PermissionController::class);
    Route::resource('courses', App\Http\Controllers\CourseController::class);
    Route::get('materials/{material}', [StudentMaterialController::class, 'show'])->name('student.materials.show');
    Route::get('materials/{material}/stream', [StudentMaterialController::class, 'stream'])->name('student.materials.stream');
    Route::get('quizzes/{quiz}', [StudentQuizController::class, 'show'])->name('student.quizzes.show');
    Route::post('quizzes/{quiz}/start', [StudentQuizController::class, 'startQuiz'])->name('student.quizzes.start');
    Route::post('quizzes/{quiz}/submit', [StudentQuizController::class, 'submit'])->name('student.quizzes.submit');
    Route::delete('/student/quizzes/{quiz}/reset', [StudentQuizController::class, 'reset'])->name('student.quizzes.reset');
});

Route::middleware(['auth', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::resource('courses.modules', ModuleController::class);
    Route::resource('courses.modules.materials', MaterialController::class);
    Route::resource('courses.modules.quizzes', QuizController::class);
    Route::resource('courses.modules.quizzes.questions', QuestionController::class);
    Route::resource('courses.modules.quizzes.questions.answers', AnswerController::class);
});

require __DIR__ . '/instructor.php';
require __DIR__ . '/auth.php';

Route::prefix('terrace')->name('terrace.')->group(function () {
    Route::get('/courses/{course}', [App\Http\Controllers\TerraceCourseController::class, 'show'])->name('courses.show');
    Route::get('/carts', [CartController::class, 'index'])->name('carts.index');
});


Route::post('carts/{course}', [CartController::class, 'store'])->name('carts.store');
Route::delete('carts/{cart}', [CartController::class, 'destroy'])->name('carts.destroy');
Route::post('/checkout', [App\Http\Controllers\TransactionController::class, 'checkout'])->name('checkout');

Route::get('/sitemap', [SitemapController::class, 'generate'])->name('sitemap.generate');
