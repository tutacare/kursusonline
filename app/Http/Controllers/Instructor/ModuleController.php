<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        $modules = $course->modules()->orderBy('order')->get();
        return view('instructor.modules.index', compact('course', 'modules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        return view('instructor.modules.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $course->modules()->create($request->all());

        return redirect()->route('instructor.courses.modules.index', $course->encrypted_id)
            ->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Module $module)
    {
        return view('instructor.modules.show', compact('course', 'module'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Module $module)
    {
        return view('instructor.modules.edit', compact('course', 'module'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Module $module)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer|min:1',
        ]);

        $module->update($request->all());

        return redirect()->route('instructor.courses.modules.index', $course->encrypted_id)
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Module $module)
    {
        $module->delete();

        return redirect()->route('instructor.courses.modules.index', $course->encrypted_id)
            ->with('success', 'Module deleted successfully.');
    }
}
