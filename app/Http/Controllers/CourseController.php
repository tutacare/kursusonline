<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view-course')->only(['index', 'show']);
        $this->middleware('permission:create-course')->only(['create', 'store']);
        $this->middleware('permission:edit-course')->only(['edit', 'update']);
        $this->middleware('permission:delete-course')->only(['destroy']);
    }
    public function index()
    {
        if (Auth::user()->hasRole(['admin', 'superadmin'])) {
            $courses = Course::with('instructor')->get();
        } else {
            $courses = Course::where('instructor_id', Auth::id())->with('instructor')->get();
        }
        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        $instructors = User::role('instructor')->get();
        return view('courses.create', compact('instructors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,publish',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            $imageName = time() . '.' . $request->cover_image->extension();
            $request->file('cover_image')->storeAs('courses', $imageName, 'public');
            $data['cover_image'] = $imageName;
        }
        if (Auth::user()->hasRole('instructor')) {
            $data['instructor_id'] = Auth::id();
        } else {
            $request->validate([
                'instructor_id' => 'required|exists:users,id',
            ]);
        }

        Course::create($data);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    public function show(Course $course)
    {
        if (Auth::user()->hasRole('instructor') && $course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('courses.show', compact('course'));
    }

    public function edit(Course $course)
    {
        if (Auth::user()->hasRole('instructor') && $course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }
        $instructors = User::role('instructor')->get();
        return view('courses.edit', compact('course', 'instructors'));
    }

    public function update(Request $request, Course $course)
    {
        if (Auth::user()->hasRole('instructor') && $course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:draft,publish',
            'price' => 'required|numeric|min:0',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('cover_image')) {
            // Delete old image if exists
            if ($course->cover_image && $course->cover_image !== 'no-image.jpg') {
                \Storage::disk('public')->delete('courses/' . $course->cover_image);
            }
            $imageName = time() . '.' . $request->cover_image->extension();
            $request->file('cover_image')->storeAs('courses', $imageName, 'public');
            $data['cover_image'] = $imageName;
        }
        if (Auth::user()->hasRole('instructor')) {
            $data['instructor_id'] = Auth::id();
        } else {
            $request->validate([
                'instructor_id' => 'required|exists:users,id',
            ]);
        }

        $course->update($data);

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    public function destroy(Course $course)
    {
        if (Auth::user()->hasRole('instructor') && $course->instructor_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($course->cover_image && $course->cover_image !== 'no-image.jpg') {
            \Storage::disk('public')->delete('courses/' . $course->cover_image);
        }

        $course->delete();

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
