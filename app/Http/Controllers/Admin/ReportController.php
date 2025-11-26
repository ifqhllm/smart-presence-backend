<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;
// Simulasi packages - in real implementation, install: composer require barryvdh/laravel-dompdf barryvdh/laravel-snappy
// use Barryvdh\DomPDF\Facade\Pdf;
// use Maatwebsite\Excel\Facades\Excel;
// use App\Exports\AttendanceReportExport;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $date = $request->get('tanggal', Carbon::today()->toDateString());
        $filter = $request->get('filter', 'harian');

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

        return view('admin.reports', compact('attendances', 'date', 'filter'));
    }

    public function generatePdfReport(Request $request)
    {
        $date = $request->get('tanggal', Carbon::today()->toDateString());
        $filter = $request->get('filter', 'harian');

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
        $date = $request->get('tanggal', Carbon::today()->toDateString());
        $filter = $request->get('filter', 'harian');

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