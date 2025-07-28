<?php

namespace App\Http\Controllers\Instructor;

use App\Models\Course;
use App\Models\Module;
use App\Models\Material;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course, Module $module)
    {
        $materials = $module->materials;
        return view('instructor.materials.index', compact('course', 'module', 'materials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course, Module $module)
    {
        return view('instructor.materials.create', compact('course', 'module'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Course $course, Module $module)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
            'type' => 'required|in:pdf,video',
        ];

        if ($request->type == 'pdf') {
            $rules['file'] = 'required|file|mimes:pdf|max:204800'; // 200MB
        } elseif ($request->type == 'video') {
            $rules['youtube_url'] = 'required|url';
            if (!Str::contains(parse_url($request->youtube_url, PHP_URL_HOST), ['youtube.com', 'youtu.be'])) {
                return back()->withErrors(['youtube_url' => 'URL harus berasal dari YouTube.']);
            }
        }

        $request->validate($rules);

        $filePath = null;
        if ($request->type == 'pdf' && $request->hasFile('file')) {
            $filePath = $request->file('file')->store('materials', 'private');
        } elseif ($request->type == 'video') {
            $filePath = $request->youtube_url;
        }

        $module->materials()->create([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $filePath,
            'order' => $request->order,
        ]);

        return redirect()->route('instructor.courses.modules.materials.index', [$course->encrypted_id, $module->encrypted_id])
            ->with('success', 'Material created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Module $module, Material $material)
    {
        return view('instructor.materials.show', compact('course', 'module', 'material'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Module $module, Material $material)
    {
        return view('instructor.materials.edit', compact('course', 'module', 'material'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course, Module $module, Material $material)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'type' => 'required|in:pdf,video',
        ];

        if ($request->type == 'pdf') {
            $rules['file'] = 'nullable|file|mimes:pdf|max:204800'; // 200MB
        } elseif ($request->type == 'video') {
            $rules['youtube_url'] = 'required|url';
            if (!Str::contains(parse_url($request->youtube_url, PHP_URL_HOST), ['youtube.com', 'youtu.be'])) {
                return back()->withErrors(['youtube_url' => 'URL harus berasal dari YouTube.']);
            }
        }

        $request->validate($rules);

        $filePath = $material->file_path;

        if ($request->type == 'pdf') {
            if ($request->hasFile('file')) {
                // Hapus file lama jika ada
                if ($material->file_path && Storage::disk('private')->exists($material->file_path)) {
                    Storage::disk('private')->delete($material->file_path);
                }

                // Simpan file ke dalam storage/app/private/materials
                $filePath = $request->file('file')->store('materials', 'private');
            }
        } elseif ($request->type == 'video') {
            // Jika berubah dari PDF ke video, hapus file PDF lama
            if ($material->type == 'pdf' && $material->file_path && Storage::disk('private')->exists($material->file_path)) {
                Storage::disk('private')->delete($material->file_path);
            }

            // Simpan URL video
            $filePath = $request->youtube_url;
        }

        $material->update([
            'title' => $request->title,
            'type' => $request->type,
            'file_path' => $filePath,
        ]);

        return redirect()->route('instructor.courses.modules.materials.index', [$course->encrypted_id, $module->encrypted_id])
            ->with('success', 'Material updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Module $module, Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();

        return redirect()->route('instructor.courses.modules.materials.index', [$course->id, $module->id])
            ->with('success', 'Material deleted successfully.');
    }
}
