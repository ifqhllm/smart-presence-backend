<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'nis' => 'required|string',
            'password' => 'required|string',
        ]);

        $student = Student::where('nis', $request->nis)->first();

        if (!$student || !Hash::check($request->password, $student->password)) {
            throw ValidationException::withMessages([
                'nis' => ['NIS atau password salah.'],
            ]);
        }

        // Simulasi: hardcode password check, asumsikan password adalah 'password' untuk semua
        // Dalam produksi, gunakan Hash::make untuk store password

        $token = $student->createToken('student-token')->plainTextToken;

        return response()->json([
            'message' => 'Login berhasil',
            'student' => $student,
            'token' => $token,
        ]);
    }
}