<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentManagementController extends Controller
{
    public function index()
    {
        $students = Student::with('classModel')->get();
        return response()->json($students);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nis' => 'required|unique:students',
            'name' => 'required',
            'password' => 'required',
            'class_id' => 'required|exists:class_models,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $student = Student::create([
            'nis' => $request->nis,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'class_id' => $request->class_id,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return response()->json($student, 201);
    }

    public function show($id)
    {
        $student = Student::with('classModel')->findOrFail($id);
        return response()->json($student);
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nis' => 'required|unique:students,nis,' . $id,
            'name' => 'required',
            'class_id' => 'required|exists:class_models,id',
            'email' => 'nullable|email',
            'phone' => 'nullable',
        ]);

        $student->update($request->only(['nis', 'name', 'class_id', 'email', 'phone']));

        if ($request->has('password')) {
            $student->update(['password' => Hash::make($request->password)]);
        }

        return response()->json($student);
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();
        return response()->json(['message' => 'Student deleted']);
    }

    public function detail($student_id)
    {
        $student = Student::with(['classModel', 'attendances'])->findOrFail($student_id);
        return response()->json([
            'profile' => $student,
            'riwayat_absen' => $student->attendances,
            'foto_wajah' => $student->photo_embedding, // assuming this is the face data
        ]);
    }
}