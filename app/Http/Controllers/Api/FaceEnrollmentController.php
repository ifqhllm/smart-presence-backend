<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;

class FaceEnrollmentController extends Controller
{
    public function registerFace(Request $request, $student_id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $student = Student::findOrFail($student_id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);

            // Simulasi: hash file gambar atau simpan path
            $photoEmbedding = hash('sha256', file_get_contents(public_path('images/' . $imageName)));

            $student->update(['photo_embedding' => $photoEmbedding]);

            return response()->json([
                'message' => 'Face enrollment berhasil',
                'photo_embedding' => $photoEmbedding,
            ]);
        }

        return response()->json(['message' => 'Gagal upload gambar'], 400);
    }
}