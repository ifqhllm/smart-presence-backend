<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        // Total students
        $totalStudents = Student::count();

        // Today's attendances
        $todayAttendances = Attendance::whereDate('time', $today)->get();

        // Count statuses
        $hadir = $todayAttendances->where('status', 'Hadir')->count();
        $terlambat = $todayAttendances->where('status', 'Terlambat')->count();
        $izin = 0; // Assuming no izin status, or add if needed
        $sakit = 0; // Assuming no sakit status
        $alpha = $totalStudents - $todayAttendances->unique('student_id')->count();

        return response()->json([
            'total_siswa' => $totalStudents,
            'hadir' => $hadir,
            'terlambat' => $terlambat,
            'izin' => $izin,
            'sakit' => $sakit,
            'alpha' => $alpha,
        ]);
    }
}