@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">
            <i class="fas fa-tachometer-alt"></i> Dashboard Presensi
        </h1>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Total Siswa</h5>
                        <h2 class="mb-0">{{ $totalStudents }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-users fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Hadir</h5>
                        <h2 class="mb-0">{{ $hadir }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Terlambat</h5>
                        <h2 class="mb-0">{{ $terlambat }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title">Alpha</h5>
                        <h2 class="mb-0">{{ $alpha }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart Section -->
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i> Statistik Presensi Hari Ini
                </h5>
            </div>
            <div class="card-body">
                <canvas id="attendanceChart" width="400" height="200"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i> Ringkasan
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <strong>Izin:</strong> {{ $izin }}
                </div>
                <div class="mb-3">
                    <strong>Sakit:</strong> {{ $sakit }}
                </div>
                <div class="mb-3">
                    <strong>Persentase Kehadiran:</strong>
                    @if($totalStudents > 0)
                        {{ number_format(($hadir / $totalStudents) * 100, 1) }}%
                    @else
                        0%
                    @endif
                </div>
                <hr>
                <small class="text-muted">
                    Data per {{ now()->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('attendanceChart').getContext('2d');
    const chartData = @json($chartData);

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: chartData.labels,
            datasets: [{
                data: chartData.data,
                backgroundColor: [
                    '#28a745', // Hadir - green
                    '#ffc107', // Terlambat - yellow
                    '#6c757d', // Izin - gray
                    '#dc3545', // Sakit - red
                    '#6f42c1'  // Alpha - purple
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom',
                }
            }
        }
    });
});
</script>
@endpush