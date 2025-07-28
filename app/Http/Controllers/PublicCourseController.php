<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Course;

class PublicCourseController extends Controller
{
    public function index()
    {
        $courses = Course::where('status', 'publish')->get();
        return view('welcome', compact('courses'));
    }
}
