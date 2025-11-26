<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Student;
use App\Services\PushNotificationService;
use Illuminate\Http\Request;

class FaceRecognitionController extends Controller
{
    public function processPresence(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'class_id' => 'required|integer',
            'location_data' => 'required|array',
            'location_data.latitude' => 'required|numeric',
            'location_data.longitude' => 'required|numeric',
        ]);

        // Simulasi verifikasi wajah: kembalikan student_id=1 jika sukses
        $recognizedStudentId = 1; // Simulasi

        $student = Student::find($recognizedStudentId);
        if (!$student) {
            return response()->json(['message' => 'Student tidak ditemukan'], 404);
        }

        // Validasi lokasi: simulasi geofencing radius
        $schoolLat = -6.2088; // Contoh koordinat sekolah
        $schoolLng = 106.8456;
        $radius = 100; // meter

        $userLat = $request->location_data['latitude'];
        $userLng = $request->location_data['longitude'];

        $distance = $this->calculateDistance($schoolLat, $schoolLng, $userLat, $userLng);

        if ($distance > $radius) {
            return response()->json(['message' => 'Lokasi di luar radius sekolah'], 403);
        }

        // Validasi jaringan: simulasi cek WiFi sekolah
        // Dalam simulasi, asumsikan selalu valid

        // Tentukan status berdasarkan waktu
        $now = now();
        $status = 'Hadir';
        if ($now->hour >= 8) { // Asumsikan jam 8 pagi
            $status = 'Terlambat';
        } elseif ($now->hour >= 15) { // Asumsikan jam 3 sore
            $status = 'Pulang';
        }

        // Catat absensi
        Attendance::create([
            'student_id' => $student->id,
            'class_id' => $request->class_id,
            'status' => $status,
            'time' => $now,
        ]);

        // Kirim notifikasi konfirmasi presensi
        $notificationService = new PushNotificationService();
        $notificationService->sendAttendanceConfirmation(
            $student->id,
            $status,
            $now->format('Y-m-d H:i:s')
        );

        return response()->json([
            'message' => 'Presensi berhasil dicatat',
            'student_id' => $student->id,
            'status' => $status,
            'time' => $now,
        ]);
    }

    private function calculateDistance($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371000; // meter

        $latDelta = deg2rad($lat2 - $lat1);
        $lngDelta = deg2rad($lng2 - $lng1);

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDelta / 2) * sin($lngDelta / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}