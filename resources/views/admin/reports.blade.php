@extends('layouts.admin')

@section('title', 'Laporan - Admin Panel')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">
                <i class="fas fa-chart-bar"></i> Laporan Presensi
            </h1>
            <div>
                <a href="{{ route('admin.reports.pdf', ['tanggal' => $date, 'filter' => $filter]) }}" class="btn btn-danger me-2" target="_blank">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('admin.reports.excel', ['tanggal' => $date, 'filter' => $filter]) }}" class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Filter Form -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.reports') }}" class="row g-3">
                    <div class="col-md-4">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ $date }}">
                    </div>
                    <div class="col-md-4">
                        <label for="filter" class="form-label">Filter</label>
                        <select class="form-select" id="filter" name="filter">
                            <option value="harian" {{ $filter == 'harian' ? 'selected' : '' }}>Harian</option>
                            <option value="mingguan" {{ $filter == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
                            <option value="bulanan" {{ $filter == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Reports Table -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    Data Presensi
                    @if($filter == 'harian')
                        - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                    @elseif($filter == 'mingguan')
                        - Minggu {{ \Carbon\Carbon::parse($date)->startOfWeek()->format('d M') }} - {{ \Carbon\Carbon::parse($date)->endOfWeek()->format('d M Y') }}
                    @else
                        - Bulan {{ \Carbon\Carbon::parse($date)->format('M Y') }}
                    @endif
                </h5>
            </div>
            <div class="card-body">
                @if($attendances->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama Siswa</th>
                                    <th>Kelas</th>
                                    <th>Status</th>
                                    <th>Waktu</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($attendances as $index => $attendance)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $attendance->student->name ?? 'N/A' }}</td>
                                        <td>{{ $attendance->classModel->name ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge
                                                @if($attendance->status == 'Hadir') bg-success
                                                @elseif($attendance->status == 'Terlambat') bg-warning
                                                @elseif($attendance->status == 'Izin') bg-info
                                                @elseif($attendance->status == 'Sakit') bg-danger
                                                @else bg-secondary
                                                @endif">
                                                {{ $attendance->status }}
                                            </span>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($attendance->time)->format('H:i:s') }}</td>
                                        <td>{{ \Carbon\Carbon::parse($attendance->time)->format('d/m/Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">
                            Total: {{ $attendances->count() }} record(s)
                        </small>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">Tidak ada data presensi</h5>
                        <p class="text-muted">Belum ada data presensi untuk filter yang dipilih.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection