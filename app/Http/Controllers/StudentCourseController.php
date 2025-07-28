<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentCourseController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $courses = $user->courses;

        return view('student.courses.index', compact('courses'));
    }

    public function show(Course $course)
    {
        $user = Auth::user();

        // Check if the user has purchased this course
        if (!$user->courses->contains($course->id)) {
            return redirect()->route('student.courses.index')->with('error', 'Anda belum membeli kursus ini.');
        }

        // Load modules, materials, and quizzes with their results for the current user
        $course->load(['modules.materials', 'modules.quizzes.quizResults' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }]);

        return view('student.courses.show', compact('course'));
    }
}