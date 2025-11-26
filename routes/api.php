<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClassController;
use App\Http\Controllers\Api\FaceEnrollmentController;
use App\Http\Controllers\Api\FaceRecognitionController;
use App\Http\Controllers\Api\Admin\StudentManagementController;
use App\Http\Controllers\Api\Admin\ReportController;
use App\Http\Controllers\Api\Admin\DashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login/siswa', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/classes', [ClassController::class, 'index']);
    Route::post('/siswa/{student_id}/register-face', [FaceEnrollmentController::class, 'registerFace']);
    Route::post('/presensi/recognize', [FaceRecognitionController::class, 'processPresence']);
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    // Student Management
    Route::apiResource('students', StudentManagementController::class);
    Route::get('siswa/{student_id}/detail', [StudentManagementController::class, 'detail']);

    // Reports
    Route::get('laporan/harian', [ReportController::class, 'harian']);
    Route::get('laporan/log-deteksi', [ReportController::class, 'logDeteksi']);
    Route::get('export/pdf', [ReportController::class, 'generatePdfReport']);
    Route::get('export/excel', [ReportController::class, 'generateExcelReport']);

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index']);
});