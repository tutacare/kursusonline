<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class StudentMaterialController extends Controller
{
    public function show(Material $material)
    {
        Gate::authorize('view', $material->module->course);

        return view('student.materials.show', compact('material'));
    }

    public function stream(Material $material)
    {
        Gate::authorize('view', $material->module->course);

        $filePath = $material->file_path;

        if (!Storage::disk('private')->exists($filePath)) {
            abort(404);
        }

        return Storage::disk('private')->response($filePath);
    }
}
