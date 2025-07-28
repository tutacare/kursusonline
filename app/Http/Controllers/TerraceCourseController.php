<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class TerraceCourseController extends Controller
{
    public function show(Course $course)
    {
        return view('terrace.courses.show', compact('course'));
    }
}
