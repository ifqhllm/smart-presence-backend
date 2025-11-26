<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function harian(Request $request)
    {
        $date = $request->query('tanggal', Carbon::today()->toDateString());
        $filter = $request->query('filter', 'harian'); // harian, mingguan, bulanan

        $query = Attendance::with(['student', 'classModel']);

        if ($filter == 'harian') {
            $query->whereDate('time', $date);
        } elseif ($filter == 'mingguan') {
            $startOfWeek = Carbon::parse($date)->startOfWeek();
            $endOfWeek = Carbon::parse($date)->endOfWeek();
            $query->whereBetween('time', [$startOfWeek, $endOfWeek]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('time', Carbon::parse($date)->month)
                  ->whereYear('time', Carbon::parse($date)->year);
        }

        $attendances = $query->get();

        return response()->json($attendances);
    }

    public function logDeteksi()
    {
        // Assuming log deteksi is the attendance records with face recognition
        // For simplicity, return all attendances as log
        $logs = Attendance::with(['student', 'classModel'])->orderBy('time', 'desc')->get();

        return response()->json($logs);
    }

    public function generatePdfReport(Request $request)
    {
        $date = $request->query('tanggal', Carbon::today()->toDateString());
        $filter = $request->query('filter', 'harian');

        $query = Attendance::with(['student', 'classModel']);

        if ($filter == 'harian') {
            $query->whereDate('time', $date);
        } elseif ($filter == 'mingguan') {
            $startOfWeek = Carbon::parse($date)->startOfWeek();
            $endOfWeek = Carbon::parse($date)->endOfWeek();
            $query->whereBetween('time', [$startOfWeek, $endOfWeek]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('time', Carbon::parse($date)->month)
                  ->whereYear('time', Carbon::parse($date)->year);
        }

        $attendances = $query->get();

        // Simulasi PDF generation - in real implementation:
        // $pdf = Pdf::loadView('admin.reports_pdf', compact('attendances', 'date', 'filter'));
        // return $pdf->download('laporan-presensi-' . $date . '.pdf');

        // For simulation, return JSON response
        return response()->json([
            'message' => 'PDF Report generated (simulated)',
            'data' => $attendances,
            'date' => $date,
            'filter' => $filter
        ]);
    }

    public function generateExcelReport(Request $request)
    {
        $date = $request->query('tanggal', Carbon::today()->toDateString());
        $filter = $request->query('filter', 'harian');

        $query = Attendance::with(['student', 'classModel']);

        if ($filter == 'harian') {
            $query->whereDate('time', $date);
        } elseif ($filter == 'mingguan') {
            $startOfWeek = Carbon::parse($date)->startOfWeek();
            $endOfWeek = Carbon::parse($date)->endOfWeek();
            $query->whereBetween('time', [$startOfWeek, $endOfWeek]);
        } elseif ($filter == 'bulanan') {
            $query->whereMonth('time', Carbon::parse($date)->month)
                  ->whereYear('time', Carbon::parse($date)->year);
        }

        $attendances = $query->get();

        // Simulasi Excel generation - in real implementation:
        // return Excel::download(new AttendanceReportExport($attendances), 'laporan-presensi-' . $date . '.xlsx');

        // For simulation, return JSON response
        return response()->json([
            'message' => 'Excel Report generated (simulated)',
            'data' => $attendances,
            'date' => $date,
            'filter' => $filter
        ]);
    }
}